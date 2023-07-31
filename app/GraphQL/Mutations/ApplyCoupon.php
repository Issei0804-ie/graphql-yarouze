<?php

namespace App\GraphQL\Mutations;


use Illuminate\Support\Facades\DB;

class ApplyCoupon
{
    public function __invoke($_, array $args)
    {
        $coupon = DB::transaction(function () use ($args) {
            $coupon = \App\Models\Coupon::findOrFail($args['code']);
            $coupon->is_used = true;
            $coupon->save();
            return $coupon;
        }, 3);
        return [
            'record' =>[
                'code' => $coupon->id,
                'isUsed' => $coupon->is_used,
            ]
        ];
    }
}
