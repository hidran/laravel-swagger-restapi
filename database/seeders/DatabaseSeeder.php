<?php

namespace Database\Seeders;

use App\Models\{Comment, Post,User};
use Database\Factories\CommentFactory;
use Database\Factories\PostFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
User::factory(100)
           ->hasPosts(100)->create();
foreach (Post::all() as $post){
    Comment::factory(50)->create([
        'post_id' => $post->id
    ]);
    }


    }
}
