<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\ActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(Request $request, ActivityLogger $logger): RedirectResponse
    {
        $credentials = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if (! Schema::hasTable('_tb_users')) {
            return back()
                ->withErrors(['login' => 'Base de usuários não encontrada. Execute as migrations antes de entrar.'])
                ->onlyInput('login');
        }

        $columns = Schema::getColumnListing('_tb_users');
        $userQuery = User::query();

        if (in_array('login', $columns, true)) {
            $userQuery->where('login', $credentials['login']);
        }

        if (in_array('email_user', $columns, true)) {
            $userQuery->orWhere('email_user', $credentials['login']);
        }

        $user = $userQuery->first();

        if (! $user || ! $this->passwordMatches($credentials['password'], $user)) {
            return back()
                ->withErrors(['login' => 'Login ou senha inválidos.'])
                ->onlyInput('login');
        }

        if (! $user->isActive()) {
            return back()
                ->withErrors(['login' => 'Usuário inativo.'])
                ->onlyInput('login');
        }

        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        $logger->record('login', "USUARIO {$user->name} ENTROU");

        return redirect()->intended(route('dashboard'));
    }

    public function destroy(Request $request, ActivityLogger $logger): RedirectResponse
    {
        if ($request->user()) {
            $logger->record('logout', "USUARIO {$request->user()->name} SAIU");
        }

        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    private function passwordMatches(string $plainPassword, User $user): bool
    {
        $stored = (string) ($user->senha ?? $user->pass_user ?? '');

        if ($stored === md5($plainPassword)) {
            return true;
        }

        return Hash::check($plainPassword, $stored);
    }
}
