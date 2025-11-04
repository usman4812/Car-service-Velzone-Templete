<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CarManufactureSeeder extends Seeder
{
    public function run()
    {
        $date = Carbon::now()->format('Y-m-d');

        $manufacturers = [
            'Acura', 'Alfa Romeo', 'Aston Martin', 'Audi',
            'BAIC', 'Bentley', 'BMW', 'Bugatti', 'Buick',
            'Cadillac', 'Changan', 'Chery', 'Chevrolet', 'Chrysler', 'Citroën',
            'Daihatsu', 'Dodge', 'Dongfeng', 'Datsun',
            'Exeed', 'FAW', 'Ferrari', 'Fiat', 'Ford', 'Foton',
            'Geely', 'Genesis', 'GMC', 'Great Wall (Haval / Tank)',
            'Haval', 'Honda', 'Hummer', 'Hyundai',
            'Infiniti', 'Isuzu',
            'Jaguar', 'Jeep',
            'Kia', 'Koenigsegg',
            'Lamborghini', 'Land Rover', 'Lexus', 'Lincoln', 'Lotus', 'Lucid',
            'Maserati', 'Mazda', 'McLaren', 'Mercedes-Benz', 'MG', 'Mini', 'Mitsubishi',
            'Nissan',
            'Opel',
            'Peugeot', 'Porsche', 'Proton',
            'Renault', 'Rolls-Royce',
            'SEAT', 'Skoda', 'Subaru', 'Suzuki', 'SsangYong', 'Smart',
            'Tata', 'Tesla', 'Toyota',
            'Volkswagen', 'Volvo',
            'Wuling',
            'Zotye',
        ];

        foreach ($manufacturers as $name) {
            DB::table('car_manufactures')->insert([
                'name' => $name,
                'image' => null,
                'status' => 'active',
                'date' => $date,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

