<?php

namespace Module\Plan\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Module\Plan\Models\Plan;
use Module\User\Models\User;

class PlanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // like https://www.spotify.com/us/premium/

        $individual = Plan::create([
            'name' => $name = 'individual',
            'slug' => Str::slug($name),
            'count_account' => 1,
            'description' => [
                'Can Download(pdf)',
                'Access to all posts',
            ],
            'price' => 9.99,
            'period' => 1,
            'interval' => 'month',
        ]);

        $duo = Plan::create([
            'name' => $name = 'duo',
            'slug' => Str::slug($name),
            'count_account' => 2,
            'description' => [
                '2 Premium accounts for a couple under one roof',
                'Can Download(pdf)',
                'Access to all posts',
            ],
            'price' => 12.99,
            'period' => 1,
            'interval' => 'month',
        ]);

        $family = Plan::create([
            'name' => $name = 'family',
            'slug' => Str::slug($name),
            'count_account' => 6,
            'description' => [
                '6 Premium accounts for family members living under one roof',
                'Can Download(pdf)',
                'Access to all posts',
            ],
            'price' => 15.99,
            'period' => 1,
            'interval' => 'month',
        ]);

        $student = Plan::create([
            'name' => $name = 'student',
            'slug' => Str::slug($name),
            'count_account' => 1,
            'description' => [
                'Hulu (ad-supported) plan',
                'Can Download(pdf)',
                'Access to all posts',
            ],
            'price' => 4.99,
            'period' => 1,
            'interval' => 'month',
        ]);

        $individual->plan_feature()->create([
            'description' => 'terms and conditions for individual plan',
        ]);

        $duo->plan_feature()->create([
            'description' => 'terms and conditions for duo plan',
        ]);

        $family->plan_feature()->create([
            'description' => 'terms and conditions for family plan',
        ]);

        $student->plan_feature()->create([
            'description' => 'terms and conditions for student plan',
        ]);

        $user = User::first();
        $user->subscribs()->create([
            'plan_id' => $duo->id,
        ]);
    }
}
