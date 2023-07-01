<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $date = date("Y-m-d H:i:s", 1413043200);

        User::create([
            'name'              => 'admin',
            'email'             => 'admin@sdno1kekeran.sch.id',
            'password'          => Hash::make('123'),
            'email_verified_at' => $date,
            'type'              => 0,
            'created_at'        => $date,
            'updated_at'        => $date
        ]);
    }
}
