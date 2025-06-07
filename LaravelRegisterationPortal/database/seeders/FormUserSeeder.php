<?php

namespace Database\Seeders;

use App\Models\FormUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FormUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FormUser::factory()->count(6)->create();
    }
}
