<?php

namespace Module\Premium\Database\Seeders;

use Illuminate\Database\Seeder;
use Module\Premium\Models\Premium;

class PremiumDatabaseSeeder extends Seeder
{
    public function run()
    {
        $premium = [
            [
                'name' => '1month',
                'details' => 'for 1 month',
                'price' => '200'
            ],
            [
                'name' => '3month',
                'details' => 'for 3 month',
                'price' => '500'
            ],
            [
                'name' => '6month',
                'details' => 'for 6 month',
                'price' => '800'
            ],
            [
                'name' => '1year',
                'details' => 'for 1 year',
                'price' => '1200'
            ],
        ];

        foreach ($premium as $key => $value) {
            Premium::create([
                'name' => $value['name'],
                'details' => $value['details'],
                'price' => $value['price'],
                'user_id' => 1
            ]);
        }
    }
}
