<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use DB;

class ProductroutesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
$i=2203;
        foreach (range(1, 200000) as $index) {
            $i++;
            DB::table('product_routes')->insert([
                'signal_id' => $i,
                'description' => "save user details for commercial vehicle loan",
                'class_map' => "\SFL\Modules\Product\Lending\CommercialVehicle",
                "action"=> "saveCustomerDetails",
                "is_active" =>1
                ]);
        }
    }
}
