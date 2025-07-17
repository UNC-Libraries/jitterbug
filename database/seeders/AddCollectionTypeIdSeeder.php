<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Jitterbug\Models\Collection;

class AddCollectionTypeIdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $uarmsId = 3;
        $shcId = 4;
        $sfcId = 5;

        $shcCollections = Collection::where('id', '<', '10000')->get();
        $sfcCollections = Collection::whereBetween('id', [20000, 39999])->get();
        $uarmsCollections = Collection::whereBetween('id', [40000, 49999])->get();

        foreach ($shcCollections as $shcCollection) {
            $shcCollection->collectionTypeId = $shcId;
            $shcCollection->save();
        }

        foreach ($sfcCollections as $sfcCollection) {
            $sfcCollection->collectionTypeId = $sfcId;
            $sfcCollection->save();
        }

        foreach ($uarmsCollections as $uarmsCollection) {
            $uarmsCollection->collectionTypeId = $uarmsId;
            $uarmsCollection->save();
        }
    }
}
