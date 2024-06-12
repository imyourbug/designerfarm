<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Constant\GlobalConstant;
use App\Models\Package;
use App\Models\Setting;
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
            'name' => 'duongvankhai2022001@gmail.com',
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
                'name' => 'Gói 150 lượt tải',
                // 'price' => '100000',
                // 'price_sale' => '10000',
                // 'number_file' => '150',
                // 'expire' => '12',
                'type' => '0',
                'website_id' => '',
                'description' => 'Giá ưu đãi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Gói 350 lượt tải',
                // 'price' => '300000',
                // 'price_sale' => '30000',
                // 'number_file' => '350',
                // 'expire' => '12',
                'type' => '0',
                'website_id' => '',
                'description' => 'Giá ưu đãi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Gói 1000 lượt tải',
                // 'price' => '1000000',
                // 'price_sale' => '100000',
                // 'number_file' => '1000',
                // 'expire' => '12',
                'type' => '0',
                'website_id' => '',
                'description' => 'Giá ưu đãi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Gói tải theo năm 10 file/ngày',
                // 'price' => '100000',
                // 'price_sale' => '10000',
                // 'number_file' => '10',
                // 'expire' => '12',
                'type' => '1',
                'website_id' => GlobalConstant::WEB_ALL,
                'description' => 'Giá ưu đãi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Gói tải theo năm 20 file/ngày',
                // 'price' => '200000',
                // 'price_sale' => '20000',
                // 'number_file' => '20',
                // 'expire' => '12',
                'type' => '1',
                'website_id' => GlobalConstant::WEB_ALL,
                'description' => 'Giá ưu đãi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Gói tải theo năm 30 file/ngày',
                // 'price' => '300000',
                // 'price_sale' => '30000',
                // 'number_file' => '30',
                // 'expire' => '12',
                'type' => '1',
                'website_id' => GlobalConstant::WEB_ENVATO,
                'description' => 'Giá ưu đãi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
        Setting::create([
            'key' => 'hotline',
            'name' => 'hotline',
            'value' => '0978315844',
        ]);
    }
}
