<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Esto busca si el usuario ya existe por correo. 
        // Si existe, lo actualiza; si no, lo crea.
        User::updateOrCreate(
            ['email' => 'damiancompany@damiancompany.com.pe'],
            [
                'name' => 'Admin Jelibeth',
                'password' => Hash::make('admin12345'),
            ]
        );
    }
}