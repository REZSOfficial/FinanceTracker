<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Payment;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Incoming;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(1)->has(Incoming::factory()->count(30))->has(Payment::factory()->count(30))->create();
    }
}
