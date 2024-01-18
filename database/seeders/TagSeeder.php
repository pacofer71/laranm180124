<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags=[
            'InforMatica'=>"#81D4FA",
            'PaIsaJe'=>"#FFF59D",
            'viajes'=>"#FFAB91",
            'programacion'=>"#EEEEEE",
            'ocio'=>"#EF9A9A",
        ];
        foreach($tags as $n=>$c){
            Tag::create([
                'nombre'=>$n,
                'color'=>$c
            ]);
        }
    }
}
