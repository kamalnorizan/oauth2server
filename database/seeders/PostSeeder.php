<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Post::create([
            'title' => 'First Post',
            'content' => 'This is the first post content',
            'user_id' => 1,
        ]);

        Post::create([
            'title' => 'First Post',
            'content' => 'This is the first post content',
            'user_id' => 1,
        ]);

        Post::create([
            'title' => 'First Post',
            'content' => 'This is the first post content',
            'user_id' => 1,
        ]);
        
        Post::create([
            'title' => 'First Post',
            'content' => 'This is the first post content',
            'user_id' => 1,
        ]);
    }
}
