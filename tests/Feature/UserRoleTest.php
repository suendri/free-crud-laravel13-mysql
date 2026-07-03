<?php

use App\Models\User;

test('user role helpers identify admins and operators', function () {
    $admin = User::factory()->make([
        'role' => 'admin',
    ]);
    $operator = User::factory()->make([
        'role' => 'operator',
    ]);

    expect($admin->isAdmin())->toBeTrue()
        ->and($admin->isOperator())->toBeFalse()
        ->and($operator->isAdmin())->toBeFalse()
        ->and($operator->isOperator())->toBeTrue();
});
