<?php

use App\Models\User;

test('ユーザー作成ができる', function () {
    $input = [
        'input' => [
            'name' => 'sampleUser',
            'email' => 'example@example.com',
            'password' => 'password',
        ],
    ];
    $response = $this->graphQL(/**
 * @lang GraphQL
*/        '
        mutation CreateUser($input: CreateUserInput!) {
            createUser(
                input: $input
            ) {
                record {
                    id
                }
            }
        }',
        $input
    );

    $response->assertJsonStructure([
        'data' => [
            'createUser' => [
                'record' => [
                    'id',
                ],
            ],
        ],
    ]);

    $this->assertDatabaseHas('users', [
        'id' => $response['data']['createUser']['record']['id'],
        'name' => $input['input']['name'],
        'email' => $input['input']['email'],
    ]);
});

test('同じemailで登録しようとすると弾かれる', function () {
    $user = User::factory()->create();

    $input = [
        'input' => [
            'name' => 'sampleUser',
            'email' => $user->email,
            'password' => 'password',
        ],
    ];
    $response = $this->graphQL(/**
 * @lang GraphQL
*/        '
        mutation CreateUser($input: CreateUserInput!) {
            createUser(
                input: $input
            ) {
                record {
                    id
                }
            }
        }',
        $input
    );

    $response->assertJsonStructure([
        'errors' => [
            [
                'message',
                'extensions' => [
                    'validation' => [
                        'input.email',
                    ],
                ],
            ],
        ],
    ]);
});

test('同じユーザー名は許される', function () {
    $user = User::factory()->create(['email' => 'sample1@example.com']);

    $input = [
        'input' => [
            'name' => $user->name,
            'email' => 'sample2@example.com',
            'password' => 'password',
        ],
    ];
    $response = $this->graphQL(/**
 * @lang GraphQL
*/        '
        mutation CreateUser($input: CreateUserInput!) {
            createUser(
                input: $input
            ) {
                record {
                    id
                }
            }
        }',
        $input
    );
    $response->assertJsonStructure([
        'data' => [
            'createUser' => [
                'record' => [
                    'id',
                ],
            ],
        ],
    ]);

    $this->assertDatabaseHas('users', [
        'id' => $response['data']['createUser']['record']['id'],
        'name' => $input['input']['name'],
        'email' => $input['input']['email'],
    ]);
});
