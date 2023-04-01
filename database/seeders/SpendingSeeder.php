<?php

namespace Database\Seeders;

use App\Models\Spending;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SpendingSeeder extends Seeder
{
    public function run(): void
    {
        Spending::truncate();
  
        $csvFile = fopen(base_path("database/data/spendings.csv"), "r");
  
        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                Spending::create([
                    "spend_list" => $data['1'],
                    "total" => $data['2'],
                    "month" => $data['3'],
                    "year" => $data['4'],
                    "created_at" => $data['5'],
                    "updated_at" => $data['6'],
                ]);    
            }
            $firstline = false;
        }
   
        fclose($csvFile);
    }
}
