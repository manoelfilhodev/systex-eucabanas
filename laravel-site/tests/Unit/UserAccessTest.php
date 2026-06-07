<?php

namespace Tests\Unit;

use App\Models\User;
use PHPUnit\Framework\TestCase;

class UserAccessTest extends TestCase
{
    public function test_developer_level_has_admin_access(): void
    {
        $user = new User([
            'cod_nivel' => '1',
            'desc_nivel' => 'Desenvolvedor',
        ]);

        $this->assertTrue($user->isAdmin());
    }
}
