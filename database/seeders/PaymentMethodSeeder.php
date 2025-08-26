<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $methods = [
            [
                'name' => 'Direct Bank Transfor',
                'description' => 'Make your payment directly into our bank account.
                                                            Please use your Order ID as the payment reference.
                                                            Your order will not be shipped until the funds have cleared in our account.',
            ],
            [
                'name' => 'Check Payments',
                'description' => 'Please send a check to Store Name, Store Street, Store Town,
                                                            Store
                                                            State / County, Store Postcode.',
            ],
            [
                'name' => 'Cash on delivery',
                'description' => 'Pay with cash upon delivery.',
            ],
        ];

        foreach ($methods as $method) {
            PaymentMethod::create($method);
        }
    }
}
