<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'      =>  'Juan Domingo',
            'email'     =>  'ju@gmail.com',
            'password'  =>  Hash::make('123456')
        ]);

        User::create([
            'name'      =>  'Roberto',
            'email'     =>  'ro@gmail.com',
            'password'  =>  Hash::make('123456')
        ]);
    }
}
