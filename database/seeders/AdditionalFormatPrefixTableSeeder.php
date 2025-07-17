<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AdditionalFormatPrefixTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $associations[] = ['format_id' => 58, 'prefix_id' => 87, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $associations[] = ['format_id' => 58, 'prefix_id' => 7, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $associations[] = ['format_id' => 58, 'prefix_id' => 27, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $associations[] = ['format_id' => 58, 'prefix_id' => 47, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $associations[] = ['format_id' => 58, 'prefix_id' => 67, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];

        DB::table('format_prefix')->insert($associations);
    }
}
