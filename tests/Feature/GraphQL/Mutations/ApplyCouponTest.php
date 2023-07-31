<?php

test('couponを適用することができる', function (){
    $coupon = \App\Models\Coupon::factory()->create();
    $input = [
        'input' => [
            'code' => $coupon->id,
        ],
    ];

    $response = $this->graphQL(/* @lang GraphQL */ '
        mutation ApplyCoupon($input: ApplyCouponInput!) {
            applyCoupon(input: $input) {
                record {
                    code
                    isUsed
                }
            }
        }',
        $input
    );

    $response
        ->assertJsonStructure([
            'data' => [
                'applyCoupon' => [
                    'record' => [
                        'code',
                        'isUsed',
                    ],
                ],
            ],
        ]);

    $this->assertDatabaseHas('coupons', [
        'id' => $input['input']['code'],
        'is_used' => true,
    ]);
});
