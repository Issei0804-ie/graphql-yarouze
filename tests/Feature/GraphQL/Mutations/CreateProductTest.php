<?php

test('商品を作成できる', function () {
    $input = [
        'input' => [
            'name' => 'test',
            'price' => 100,
            'stock' => 10,
        ],
    ];

    $response = $this->graphQL(/**
 * @lang GraphQL
*/        '
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
