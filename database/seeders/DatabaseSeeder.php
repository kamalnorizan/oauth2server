<?php

namespace Database\Seeders;

use Carbon\Carbon;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(50)->create();
        // Post::factory(300)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // $this->call([
        //     PostSeeder::class,
        // ]);

        User::each(function ($user) {
            $randomDate = Carbon::createFromTimestamp(rand(
                Carbon::parse('1980-01-01')->timestamp,
                Carbon::parse('2010-12-31')->timestamp
            ))->format('ymd');

            $user->update([
                'identity'=> $randomDate.rand(10,50).rand(1000,6000),
            ]);
        });
    }
}
