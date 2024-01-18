<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Creamos 50 POSTS
        $posts=Post::factory(50)->create();
        //ASIGNAMOS A CADA POSTS un numero aleatorio de tags y lo guardamos en post_tag
        foreach($posts as $item){
            $item->tags()->attach($this->devolverIdTagsRandom());
        }
    }
    private function devolverIdTagsRandom(): array{
        $tags=[];
        $arrayTags=Tag::pluck('id')->toArray(); // [ma,pac,lui,jua,and] ->0,1,2,3,4 $arrayTags[3]=4
        $arrayIndices=array_rand($arrayTags, random_int(2,count($arrayTags))); //[0,1], [0,1,3], [3,4], [0,2,3,4]
        foreach($arrayIndices as $indice){
            $tags[]=$arrayTags[$indice];
        }
        return $tags;
    }
}
