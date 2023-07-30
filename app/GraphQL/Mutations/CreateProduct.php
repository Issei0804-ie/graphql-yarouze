<?php

namespace App\GraphQL\Mutations;

use App\Models\Product;
use App\Models\User;

class CreateProduct
{
    public function __invoke($_, array $args)
    {
        $product = Product::create([
            'name' => $args['name'],
            'price' => $args['price'],
            'stock' => $args['stock'],
        ]);
        return ['record' => $product];
    }
}
