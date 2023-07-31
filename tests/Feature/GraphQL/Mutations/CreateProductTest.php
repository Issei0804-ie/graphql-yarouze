<?php

test('商品を作成できる', function () {
    $input = [
        'input' => [
            'name' => 'test',
            'price' => 100,
            'stock' => 10,
        ],
    ];

    $response = $this->graphQL(/* @lang GraphQL */ '
        mutation CreateProduct($input: CreateProductInput!) {
            createProduct(input: $input) {
                record {
                    id
                    name
                    price
                    stock
                }
            }
        }',
        $input
    );

    $response
        ->assertJsonStructure([
            'data' => [
                'createProduct' => [
                    'record' => [
                        'id',
                        'name',
                        'price',
                        'stock',
                    ],
                ],
            ],
        ]);

    $this->assertDatabaseHas('products', [
        'name' => $input['input']['name'],
        'price' => $input['input']['price'],
        'stock' => $input['input']['stock'],
    ]);
});

test('各パラメータが存在しないまま送信すると、エラーになる', function ($name, $price, $stock) {
    $input = [
        'input' => [
            'name' => $name,
            'price' => $price,
            'stock' => $stock,
        ],
    ];

    $response = $this->graphQL(/* @lang GraphQL */        '
        mutation CreateProduct($input: CreateProductInput!) {
            createProduct(input: $input) {
                record {
                    id
                    name
                    price
                    stock
                }
            }
        }',
        $input
    );

    $response
        ->assertJsonStructure([
            'errors' => [
                [
                    'message',
                ],
            ],
        ]);
})
    ->with(
        [
            [null, 100, 10],
            ['test', null, 10],
            ['test', 100, null],
        ]
    );


