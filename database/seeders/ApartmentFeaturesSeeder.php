<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ApartmentFeaturesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $features = [
            "Air Conditioning",
            "Alarm System",
            "Beach Access",
            "Cable TV Hookups",
            "Cable TV included",
            "Controlled Access Buildings",
            "Corporate/furnished Available",
            "Disability Access",
            "Dishwasher",
            "Eat in Kitchen or Dining Room",
            "Fireplace-Gas",
            "Fireplace-Wood",
            "Floors-Carpet",
            "Floors-cement",
            "Floors-Tile",
            "Floors-Wood",
            "High Speed Internet",
            "High/Vaulted Ceilings",
            "Loft",
            "Microwave",
            "Parking-Attached Garages",
            "Parking-Carports",
            "Parking-Detached Garages",
            "Parking-Parking Garage",
            "Patio or Balcony",
            "Private Entry",
            "Private or Fenced Yard",
            "Satellite Dish OK",
            "Spa and/or Sauna",
            "Storage-Additional",
            "Utilities-Heat Paid",
            "Utilities-Water Paid",
            "Views-City",
            "Views-Mountain",
            "Views-Ocean/Lake",
            "Washer Dryer Hookup",
            "Washer Dryer In Unit",
            "Washer Dryer- Rental Available",
            "Ceiling fans",
            "Walk in closets",
        ];
        foreach ($features as $feature) {
            DB::table('apartment_features')->insert([
                'name' => $feature,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
