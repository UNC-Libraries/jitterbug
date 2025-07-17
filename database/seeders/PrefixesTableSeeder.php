<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PrefixesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $ncpaId = 1;
        $rbcId = 2;
        $uarmsId = 3;
        $shcId = 4;
        $sfcId = 5;
        $prefixes[] = ['id' => 1, 'label' => 'F', 'legacy' => 0, 'collection_type_id' => $ncpaId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 2, 'label' => 'VT', 'legacy' => 0, 'collection_type_id' => $ncpaId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 3, 'label' => 'DDVD', 'legacy' => 0, 'collection_type_id' => $ncpaId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 4, 'label' => 'DVD', 'legacy' => 0, 'collection_type_id' => $ncpaId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 5, 'label' => 'C', 'legacy' => 0, 'collection_type_id' => $ncpaId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 6, 'label' => '8T', 'legacy' => 0, 'collection_type_id' => $ncpaId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 7, 'label' => 'T', 'legacy' => 0, 'collection_type_id' => $ncpaId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 8, 'label' => 'DAT', 'legacy' => 0, 'collection_type_id' => $ncpaId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 9, 'label' => 'CD', 'legacy' => 0, 'collection_type_id' => $ncpaId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 10, 'label' => 'DCD', 'legacy' => 0, 'collection_type_id' => $ncpaId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 11, 'label' => 'FD', 'legacy' => 0, 'collection_type_id' => $ncpaId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 12, 'label' => 'TR', 'legacy' => 0, 'collection_type_id' => $ncpaId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 13, 'label' => 'WR', 'legacy' => 0, 'collection_type_id' => $ncpaId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 14, 'label' => '45', 'legacy' => 0, 'collection_type_id' => $ncpaId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 15, 'label' => '78', 'legacy' => 0, 'collection_type_id' => $ncpaId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 16, 'label' => 'CY', 'legacy' => 0, 'collection_type_id' => $ncpaId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 17, 'label' => 'MD', 'legacy' => 0, 'collection_type_id' => $ncpaId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 18, 'label' => 'FC', 'legacy' => 0, 'collection_type_id' => $ncpaId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 19, 'label' => 'D', 'legacy' => 0, 'collection_type_id' => $ncpaId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 20, 'label' => 'VM', 'legacy' => 0, 'collection_type_id' => $ncpaId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];

        $prefixes[] = ['id' => 21, 'label' => 'F', 'legacy' => 0, 'collection_type_id' => $rbcId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 22, 'label' => 'VT', 'legacy' => 0, 'collection_type_id' => $rbcId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 23, 'label' => 'DDVD', 'legacy' => 0, 'collection_type_id' => $rbcId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 24, 'label' => 'DVD', 'legacy' => 0, 'collection_type_id' => $rbcId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 25, 'label' => 'C', 'legacy' => 0, 'collection_type_id' => $rbcId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 26, 'label' => '8T', 'legacy' => 0, 'collection_type_id' => $rbcId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 27, 'label' => 'T', 'legacy' => 0, 'collection_type_id' => $rbcId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 28, 'label' => 'DAT', 'legacy' => 0, 'collection_type_id' => $rbcId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 29, 'label' => 'CD', 'legacy' => 0, 'collection_type_id' => $rbcId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 30, 'label' => 'DCD', 'legacy' => 0, 'collection_type_id' => $rbcId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 31, 'label' => 'FD', 'legacy' => 0, 'collection_type_id' => $rbcId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 32, 'label' => 'TR', 'legacy' => 0, 'collection_type_id' => $rbcId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 33, 'label' => 'WR', 'legacy' => 0, 'collection_type_id' => $rbcId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 34, 'label' => '45', 'legacy' => 0, 'collection_type_id' => $rbcId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 35, 'label' => '78', 'legacy' => 0, 'collection_type_id' => $rbcId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 36, 'label' => 'CY', 'legacy' => 0, 'collection_type_id' => $rbcId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 37, 'label' => 'MD', 'legacy' => 0, 'collection_type_id' => $rbcId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 38, 'label' => 'FC', 'legacy' => 0, 'collection_type_id' => $rbcId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 39, 'label' => 'D', 'legacy' => 0, 'collection_type_id' => $rbcId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 40, 'label' => 'VM', 'legacy' => 0, 'collection_type_id' => $rbcId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];

        $prefixes[] = ['id' => 41, 'label' => 'F', 'legacy' => 0, 'collection_type_id' => $uarmsId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 42, 'label' => 'VT', 'legacy' => 0, 'collection_type_id' => $uarmsId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 43, 'label' => 'DDVD', 'legacy' => 0, 'collection_type_id' => $uarmsId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 44, 'label' => 'DVD', 'legacy' => 0, 'collection_type_id' => $uarmsId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 45, 'label' => 'C', 'legacy' => 0, 'collection_type_id' => $uarmsId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 46, 'label' => '8T', 'legacy' => 0, 'collection_type_id' => $uarmsId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 47, 'label' => 'T', 'legacy' => 0, 'collection_type_id' => $uarmsId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 48, 'label' => 'DAT', 'legacy' => 0, 'collection_type_id' => $uarmsId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 49, 'label' => 'CD', 'legacy' => 0, 'collection_type_id' => $uarmsId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 50, 'label' => 'DCD', 'legacy' => 0, 'collection_type_id' => $uarmsId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 51, 'label' => 'FD', 'legacy' => 0, 'collection_type_id' => $uarmsId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 52, 'label' => 'TR', 'legacy' => 0, 'collection_type_id' => $uarmsId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 53, 'label' => 'WR', 'legacy' => 0, 'collection_type_id' => $uarmsId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 54, 'label' => '45', 'legacy' => 0, 'collection_type_id' => $uarmsId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 55, 'label' => '78', 'legacy' => 0, 'collection_type_id' => $uarmsId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 56, 'label' => 'CY', 'legacy' => 0, 'collection_type_id' => $uarmsId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 57, 'label' => 'MD', 'legacy' => 0, 'collection_type_id' => $uarmsId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 58, 'label' => 'FC', 'legacy' => 0, 'collection_type_id' => $uarmsId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 59, 'label' => 'D', 'legacy' => 0, 'collection_type_id' => $uarmsId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 60, 'label' => 'VM', 'legacy' => 0, 'collection_type_id' => $uarmsId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];

        $prefixes[] = ['id' => 61, 'label' => 'F', 'legacy' => 0, 'collection_type_id' => $shcId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 62, 'label' => 'VT', 'legacy' => 0, 'collection_type_id' => $shcId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 63, 'label' => 'DDVD', 'legacy' => 0, 'collection_type_id' => $shcId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 64, 'label' => 'DVD', 'legacy' => 0, 'collection_type_id' => $shcId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 65, 'label' => 'C', 'legacy' => 0, 'collection_type_id' => $shcId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 66, 'label' => '8T', 'legacy' => 0, 'collection_type_id' => $shcId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 67, 'label' => 'T', 'legacy' => 0, 'collection_type_id' => $shcId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 68, 'label' => 'DAT', 'legacy' => 0, 'collection_type_id' => $shcId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 69, 'label' => 'CD', 'legacy' => 0, 'collection_type_id' => $shcId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 70, 'label' => 'DCD', 'legacy' => 0, 'collection_type_id' => $shcId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 71, 'label' => 'FD', 'legacy' => 0, 'collection_type_id' => $shcId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 72, 'label' => 'TR', 'legacy' => 0, 'collection_type_id' => $shcId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 73, 'label' => 'WR', 'legacy' => 0, 'collection_type_id' => $shcId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 74, 'label' => '45', 'legacy' => 0, 'collection_type_id' => $shcId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 75, 'label' => '78', 'legacy' => 0, 'collection_type_id' => $shcId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 76, 'label' => 'CY', 'legacy' => 0, 'collection_type_id' => $shcId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 77, 'label' => 'MD', 'legacy' => 0, 'collection_type_id' => $shcId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 78, 'label' => 'FC', 'legacy' => 0, 'collection_type_id' => $shcId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 79, 'label' => 'D', 'legacy' => 0, 'collection_type_id' => $shcId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 80, 'label' => 'VM', 'legacy' => 0, 'collection_type_id' => $shcId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];

        $prefixes[] = ['id' => 81, 'label' => 'F', 'legacy' => 0, 'collection_type_id' => $sfcId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 82, 'label' => 'VT', 'legacy' => 0, 'collection_type_id' => $sfcId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 83, 'label' => 'DDVD', 'legacy' => 0, 'collection_type_id' => $sfcId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 84, 'label' => 'DVD', 'legacy' => 0, 'collection_type_id' => $sfcId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 85, 'label' => 'FS', 'legacy' => 0, 'collection_type_id' => $sfcId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 86, 'label' => '8T', 'legacy' => 0, 'collection_type_id' => $sfcId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 87, 'label' => 'FT', 'legacy' => 0, 'collection_type_id' => $sfcId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 88, 'label' => 'DAT', 'legacy' => 0, 'collection_type_id' => $sfcId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 89, 'label' => 'CD', 'legacy' => 0, 'collection_type_id' => $sfcId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 90, 'label' => 'DCD', 'legacy' => 0, 'collection_type_id' => $sfcId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 91, 'label' => 'FD', 'legacy' => 0, 'collection_type_id' => $sfcId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 92, 'label' => 'TR', 'legacy' => 0, 'collection_type_id' => $sfcId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 93, 'label' => 'WR', 'legacy' => 0, 'collection_type_id' => $sfcId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 94, 'label' => '45', 'legacy' => 0, 'collection_type_id' => $sfcId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 95, 'label' => '78', 'legacy' => 0, 'collection_type_id' => $sfcId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 96, 'label' => 'CY', 'legacy' => 0, 'collection_type_id' => $sfcId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 97, 'label' => 'MD', 'legacy' => 0, 'collection_type_id' => $sfcId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 98, 'label' => 'FC', 'legacy' => 0, 'collection_type_id' => $sfcId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 99, 'label' => 'D', 'legacy' => 0, 'collection_type_id' => $sfcId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 100, 'label' => 'VM', 'legacy' => 0, 'collection_type_id' => $sfcId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];

        $prefixes[] = ['id' => 101, 'label' => 'D', 'legacy' => 1, 'collection_type_id' => $shcId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 102, 'label' => 'D', 'legacy' => 1, 'collection_type_id' => $uarmsId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 103, 'label' => 'VUT', 'legacy' => 1, 'collection_type_id' => $sfcId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 104, 'label' => 'VHS', 'legacy' => 1, 'collection_type_id' => $sfcId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 105, 'label' => 'V8M', 'legacy' => 1, 'collection_type_id' => $sfcId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $prefixes[] = ['id' => 106, 'label' => 'VOR', 'legacy' => 1, 'collection_type_id' => $sfcId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];

        DB::table('prefixes')->insert($prefixes);
    }
}
