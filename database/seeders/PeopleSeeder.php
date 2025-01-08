<?php

namespace Database\Seeders;

use App\Models\People;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PeopleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        People::create(
            [
                'first_name' => 'Lucky John',
                'last_name' => 'Faderon',
                'dob' => '1988-08-04',
                'gender' => 'male',
            ]
        );

        People::factory()->count(10)->create();
    }
}
