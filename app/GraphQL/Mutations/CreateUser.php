<?php

namespace App\GraphQL\Mutations;

use App\Models\User;

class CreateUser {
    public function __invoke($_, array $args)
    {
        return User::create([
            'name' => $args['name'],
            'email' => $args['email'],
            'password' => \Hash::make($args['password']),
        ]);

    }
}