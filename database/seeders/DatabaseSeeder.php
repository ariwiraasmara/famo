<?php
namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;
use App\Libraries\myfunction;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // \App\Models\User::factory()->create([
        //     'name' => 'Admin Famo',
        //     'email' => 'admin@gmail.com',
        //     'password' => myfunction::encrypt_pass(1234567890),
        // ]);

        for($x = 1; $x < 21; $x++) {
            \App\Models\User::factory()->create([
                'name'              => 'username'.$x,
                'email'             => 'username'.$x.'@usermail.com',
                'email_verified_at' => date('Y-m-d H:i:s'),
                // 'password'          => myfunction::encrypt_pass('username'.$x),
                'password'          => Hash::make('username'.$x),
                'remember_token'    => null,
                'roles'             => 3
            ]);
        }

       
    }
}
