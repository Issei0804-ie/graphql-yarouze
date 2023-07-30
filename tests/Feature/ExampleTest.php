<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Nuwave\Lighthouse\Testing\MakesGraphQLRequests;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;
    use MakesGraphQLRequests;
    /**
     * A basic test example.
     */
    #[test]
    public function ユーザー作成ができる()
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
    }
}
