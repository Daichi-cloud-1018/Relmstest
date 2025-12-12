<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeasonsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $season = [
            'name' => '春',
        ];
        DB::table('seasons')->insert($season);
        $season = [
            'name' => '夏',
        ];
        DB::table('seasons')->insert($season);
        $season = [
            'name' => '秋',
        ];
        DB::table('seasons')->insert($season);
        $season = [
            'name' => '冬',
        ];
        DB::table('seasons')->insert($season);
    }
}
