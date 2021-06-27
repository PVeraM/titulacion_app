<?php

namespace Database\Seeders;

use App\Models\Enterprise;
use App\Models\Service;
use App\Models\Store;
use Illuminate\Database\Seeder;

class EnterpriseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $enterprises = Enterprise::factory()->count(5)->create();
        $enterprises->each( function ($enterprise) {
            $stores = Store::factory()
                ->count(2)
                ->make();
            $enterprise->stores()->saveMany($stores);
        });

        $services = Service::factory()->count(2)->create();
        $stores = Store::all();
        $services->each( function ( $service ) use ( $stores) {
            $service->stores()->saveMany($stores);
        });
    }
}
