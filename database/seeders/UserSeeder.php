<?php

namespace Database\Seeders;

use App\Models\OperationEnter;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'),
            'company_name' => 'comapny 1',
            'form_of_organization' => 'organization 1',
            'form_of_income_taxes' => 'income tax type 1',
            'contact_with_us' => 'contact detail 1'
        ]);
        
        OperationEnter::factory()->count(500)->create();
    }
}
