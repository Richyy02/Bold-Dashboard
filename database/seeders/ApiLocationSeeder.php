<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class ApiLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('api_locations')->insert([
            'id' => 1,
            'uri' => 7270,
            'api_key' => '***REMOVED***',
            'slug' => 'voorkappers_nl',
            'name' => 'Voorkappers NL',
    ]);
        DB::table('api_locations')->insert([
            'id' => 2,
            'uri' => 35574,
            'api_key' => '***REMOVED***',
            'slug' => 'dailystyle',
            'name' => 'Dailystyle',
    ]);
        DB::table('api_locations')->insert([
            'id' => 3,
            'uri' => ' ',
            'api_key' => '***REMOVED***',
            'slug' => 'boldmail',
            'name' => 'Boldmail',
    ]);
        DB::table('api_locations')->insert([
            'id' => 4,
            'uri' => 4337,
            'api_key' => '***REMOVED***',
            'slug' => 'tennisdirect',
            'name' => 'Tennisdirect',
    ]);
        DB::table('api_locations')->insert([
            'id' => 5,
            'uri' => 4335,
            'api_key' => '***REMOVED***',
            'slug' => 'vlisco',
            'name' => 'Vlisco',
    ]);
    }
}
