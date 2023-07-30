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
