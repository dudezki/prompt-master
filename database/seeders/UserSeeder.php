<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserAvatar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'person_id' => 1,
            'username' => 'dudezkie',
            'password' => Hash::make('iF4D3R0N88!'),
        ]);

        // Create avatar from the initial of the username
        $initial = strtoupper($user->username[0]);
        $avatarBlob = createDefaultAvatar($initial);

        // Insert the default avatar for the created user
        UserAvatar::insert([
            'user_id' => $user->id,
            'avatar' => $avatarBlob,
            'avatar_type' => 'image/png',
            'is_current' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
