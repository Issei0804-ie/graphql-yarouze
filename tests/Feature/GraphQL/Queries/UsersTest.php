<?php

use App\Models\User;

test('ページネーションでユーザーを取得できる', function () {
    $users = User::factory()->count(10)->create();

    $response = $this->graphQL(/** @lang GraphQL */'
        query Users($first: Int, $page: Int) {
            users(
                first: $first,
                page: $page
            ) {
                data {
                    id
                }
            }
        }', [
            'first' => 10,
            'page' => 0,
        ]);
    $response
        ->assertJson([
            'data' => [
                'users' => [
                    'data' => $users->map(function ($user) {
                        return [
                            'id' => $user->id,
                        ];
                    })->toArray(),
                ],
            ],
        ])
        ->assertJsonCount(10, 'data.users.data');
});

test('nameを部分一致で検索し、ページネーションでユーザーを取得できる', function () {
    $users = User::factory()->count(10)->create(['name' => 'testTest']);

    $response = $this->graphQL(/** @lang GraphQL */'
        query Users($name: String, $first: Int, $page: Int) {
            users(
                name: $name,
                first: $first,
                page: $page
            ) {
                data {
                    id
                }
            }
        }', [
            'name' => 'test%',
            'first' => 10,
            'page' => 0,
        ]);

    $response
        ->assertJson([
            'data' => [
                'users' => [
                    'data' => $users->map(function ($user) {
                        return [
                            'id' => $user->id,
                        ];
                    })->toArray(),
                ],
            ],
        ])
        ->assertJsonCount($users->count(), 'data.users.data');
});
