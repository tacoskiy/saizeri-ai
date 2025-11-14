<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class TabletAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            "name" => "Table-Tablet",
            "role" => "table_device",
            "email" => "demo1234@demo.com",
            "password" => Hash::make("demo1234"),
        ]);
        
    }
}
