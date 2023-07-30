<?php

namespace App\GraphQL\Mutations;

use App\Models\User;

class CreateUser {
    public function __invoke($_, array $args)
    {
        $user = User::create([
            'name' => $args['name'],
            'email' => $args['email'],
            'password' => \Hash::make($args['password']),
        ]);
        logger()->info('user ', ['user' => $user]);
        return ['record' => $user];
    }
}
