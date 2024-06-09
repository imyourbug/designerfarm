<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Constant\GlobalConstant;
use App\Models\Package;
use App\Models\Website;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::create([
            'email' => 'duongvankhai2022001@gmail.com',
            'password' => Hash::make(1),
            'role' => 1,
            'balance' => 10000000000,
        ]);

        // website
        foreach (GlobalConstant::WEB_TYPE as $website) {
            Website::create([
                'code' => $website
            ]);
        }

        Package::insert([
            [
                'name' => 'Gói tải theo số lượt',
                'price' => '100000',
                'price_sale' => '10000',
                'number_file' => '150',
                'expire' => '12',
                'type' => '0',
                'website_id' => '',
                'description' => 'Giá ưu đãi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Gói tải theo năm',
                'price' => '100000',
                'price_sale' => '50000',
                'number_file' => '20',
                'expire' => '12',
                'type' => '1',
                'website_id' => GlobalConstant::WEB_ALL,
                'description' => 'Giá ưu đãi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
