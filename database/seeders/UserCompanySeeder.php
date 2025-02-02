<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserCompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i <= 30; $i++) {
            DB::table('user_company')->insert([
                'user_id' => rand(1, 10),
                'company_id' => rand(1, 10),
            ]);
        }
    }
}
