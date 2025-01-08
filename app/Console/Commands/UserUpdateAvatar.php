<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UserUpdateAvatar extends Command
{
    protected $signature = 'user:update-avatar';
    protected $description = 'Update user avatar for user_id = 1';

    public function handle()
    {
        $filePath = public_path('assets/images/favicon/favicon.png');
        if (!file_exists($filePath)) {
            $this->error('File not found: ' . $filePath);
            return;
        }

        $fileContent = file_get_contents($filePath);
        $fileBlob = base64_encode($fileContent);

        DB::table('user_avatars')
            ->where('user_id', 1)
            ->update(['avatar' => $fileBlob]);

        $this->info('User avatar updated successfully.');
    }
}
