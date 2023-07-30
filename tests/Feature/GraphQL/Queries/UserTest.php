<?php

use App\Models\User;

test('idを指定してユーザーを取得することができる', function (){
    $user = User::factory()->create();

    $response = $this->graphQL(/** @lang GraphQL */'
        query User($id: ID!) {
            user(
                id: $id
            ) {
                id
                name
                email
            }
        }', [
            'id' => $user->id,
        ]);

    $response->assertJson([
        'data' => [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
        ],
    ]);
});

test('emailを指定してユーザーを取得できる', function () {
    $user = User::factory()->create();

    $response = $this->graphQL(/** @lang GraphQL */'
        query User($email: String!) {
            user(
                email: $email
            ) {
                id
                name
                email
            }
        }', [
            'email' => $user->email,
        ]);

    $response->assertJson([
        'data' => [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
        ],
    ]);
});
