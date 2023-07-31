<?php

test('idを指定して商品を検索することができる', function (){
   $product = \App\Models\Product::factory()->create();

   $response = $this
       ->graphQL(/** @lang GraphQL */'
            query Product($id: ID!) {
                product(id:$id) {
                    id
                    name
                    price
                }
            }
       ', ['id' => $product->id]);

   $response
       ->assertJson(
           [
               'data' => [
                   'product' => [
                       'id' => $product->id,
                       'name' => $product->name,
                       'price' => $product->price
                   ]
               ]
           ]
       );
});

test('存在しないidを指定すると空が返ってくる', function () {
    $response = $this
        ->graphQL(/** @lang GraphQL */'
            query Product($id: ID!) {
                product(id:$id) {
                    id
                    name
                    price
                }
            }
        ', ['id' => 1]);

    $response
        ->assertJson(
            [
                'data' => [
                    'product' => null
                ]
            ]
        );
});

test('idにstringを入れるとnullが返ってくる', function () {
    $response = $this
        ->graphQL(/** @lang GraphQL */'
            query Product($id: ID!) {
                product(id:$id) {
                    id
                    name
                    price
                }
            }
        ', ['id' => 'test']);

    $response
        ->assertJson(
            [
                'data' => [
                    'product' => null
                ]
            ]
        );
});
