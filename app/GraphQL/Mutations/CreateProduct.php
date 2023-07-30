<?php

namespace App\GraphQL\Mutations;

use App\Models\Products;
use App\Models\User;

class CreateProduct {
    public function __invoke($_, array $args)
    {
        $product = Products::create([
            'name' => $args['name'],
            'price' => $args['price'],
            'stock' => $args['stock'],
        ]);
        return ['record' => $product];
    }
}
