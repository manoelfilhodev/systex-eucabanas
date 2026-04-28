<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLegacyUserRequest;
use App\Models\User;
use App\Services\ActivityLogger;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = Schema::hasTable('_tb_users')
            ? User::query()->orderBy('nome')->paginate(20)
            : collect();

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.form', ['legacyUser' => new User]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLegacyUserRequest $request, ActivityLogger $logger)
    {
        $data = $request->validated();
        $data['cod_nivel'] = $request->input('cod_nivel');
        $data['senha'] = Hash::make($data['senha']);
        $data['status'] = $data['status'] ?? 'ATIVO';

        $user = User::query()->create($data);

        $logger->record('create', "ADMIN {$request->user()->name} CADASTROU O USUARIO {$user->name}");

        return redirect()->route('users.index')->with('status', 'Usuário cadastrado com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('users.form', ['legacyUser' => User::query()->findOrFail($id)]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreLegacyUserRequest $request, string $id, ActivityLogger $logger)
    {
        $data = $request->validated();
        $data['cod_nivel'] = $request->input('cod_nivel');

        if (blank($data['senha'] ?? null)) {
            unset($data['senha']);
        } else {
            $data['senha'] = Hash::make($data['senha']);
        }

        $user = User::query()->findOrFail($id);
        $user->update($data);

        $logger->record('update', "ADMIN {$request->user()->name} ALTEROU O USUARIO {$user->name}");

        return redirect()->route('users.index')->with('status', 'Usuário atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, ActivityLogger $logger)
    {
        $user = User::query()->findOrFail($id);

        if ($user->getKey() === auth()->id()) {
            return back()->withErrors(['user' => 'Você não pode inativar o próprio usuário.']);
        }

        if ($user->isAdmin()) {
            $activeAdmins = User::query()
                ->where('status', 'ATIVO')
                ->whereKeyNot($user->getKey())
                ->where(function ($query): void {
                    $query->where('cod_nivel', '0')->orWhere('desc_nivel', 'like', '%Admin%');
                })
                ->count();

            if ($activeAdmins === 0) {
                return back()->withErrors(['user' => 'Mantenha pelo menos um administrador ativo no sistema.']);
            }
        }

        $user->update(['status' => 'INATIVO']);

        $logger->record('delete', "ADMIN INATIVOU O USUARIO {$user->name}");

        return redirect()->route('users.index')->with('status', 'Usuário inativado com sucesso.');
    }
}
