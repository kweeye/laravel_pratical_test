<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);


        DB::table('form_render')->insert([
            [
                'field' => "text",
                'form_name' => "name",
                'label' => "Name",
                'select_option' => null
            ],
            [
                'field' => "text",
                'form_name' => "phone_number",
                'label' => "Phone Number",
                'select_option' => null
            ],
            [
                'field' => "date",
                'form_name' => "dob",
                'label' => "Date Of Birth",
                'select_option' => null
            ],
            [
                'field' => "select",
                'form_name' => "gender",
                'label' => "Gender",
                'select_option' => "Male,Female"
            ]
        ]);
    }
}
