<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CollectionTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $collectionTypes[] = ['id' => 1, 'name' => 'NCCPA', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
      $collectionTypes[] = ['id' => 2, 'name' => 'RBC', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
      $collectionTypes[] = ['id' => 3, 'name' => 'UARMS', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
      $collectionTypes[] = ['id' => 4, 'name' => 'SHC', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
      $collectionTypes[] = ['id' => 5, 'name' => 'SFC', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
      DB::table('collection_types')->insert($collectionTypes);
    }
}
