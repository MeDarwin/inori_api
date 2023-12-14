<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        /* ------------------------------- USER SEEDER ------------------------------ */
        //Admin user
        \App\Models\User::factory()->create([
            'username' => 'admin.inori',
            'nis_nip'  => '123456789012',
            'nisn'     => '2122121212',
            'email'    => 'admin@example.com',
            'password' => Hash::make('password123'),
            'role'     => 'admin',
        ]);

        //Member user
        \App\Models\User::factory()->create([
            'username' => 'member.inori',
            'nis_nip'  => '123456789013',
            'nisn'     => '2122121213',
            'email'    => 'member@example.com',
            'password' => Hash::make('password123'),
            'role'     => 'member',
        ]);

        //Club leader user
        \App\Models\User::factory()->create([
            'username' => 'leader.inori',
            'nis_nip'  => '123456789014',
            'nisn'     => '2122121214',
            'email'    => 'leader@example.com',
            'password' => Hash::make('password123'),
            'role'     => 'club_leader',
        ]);

        //Club mentor user
        \App\Models\User::factory()->create([
            'username' => 'mentor.inori',
            'nis_nip'  => '123456789015',
            'nisn'     => '2122121215',
            'email'    => 'mentor@example.com',
            'password' => Hash::make('password123'),
            'role'     => 'club_mentor',
        ]);

        //Osis user
        \App\Models\User::factory()->create([
            'username' => 'osis.inori',
            'nis_nip'  => '123456789016',
            'nisn'     => '2122121216',
            'email'    => 'osis@example.com',
            'password' => Hash::make('password123'),
            'role'     => 'osis',
        ]);
        //Division lead user example
        \App\Models\User::factory()->create([
            'username' => 'div.lead.inori',
            'nis_nip'  => '123456789017',
            'nisn'     => '2122121217',
            'email'    => 'div.lead@example.com',
            'password' => Hash::make('password123'),
            'role'     => 'member',
        ]);
        /* ------------------------------- USER SEEDER ------------------------------ */

        /* ------------------------------- DIVISION SEEDER ------------------------------ */
        \App\Models\Division::factory()->create([
            'name' => 'magazine',
            'division_lead' => 'div.lead.inori',
            'vision' => 'Making a good magazine for the club and entertain everyone with amazing content.',
            'mission' => '1. To promote the club activities and members.\n2. To promote the club activities and members.\n3. To promote the club activities and members.',
        ]);
    }
}
