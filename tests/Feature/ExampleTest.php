<?php

test('ユーザー作成ができる', function ()
{
    $input = [
        'input' => [
            'name' => 'sampleUser',
            'email' => 'example@example.com',
            'password' => 'password',
        ]
    ];
    $response = $this->graphQL(/** @lang GraphQL */'
        mutation CreateUser($input: CreateUserInput!) {
            createUser(
                input: $input
            ) {
                record {
                    id
                }
            }
        }',$input);

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
