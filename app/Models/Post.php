<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    use HasFactory;
    protected $fillable=['titulo', 'contenido', 'estado', 'imagen'];

    //Relacion N:M con tags
    public function tags(): BelongsToMany{
        return $this->belongsToMany(Tag::class);
    }
    //accesors y muttators
    public function titulo(): Attribute{
        return Attribute::make(
            set: fn($v)=>ucfirst($v),
        );
    }
    public function contenido(): Attribute{
        return Attribute::make(
            set: fn($v)=>ucfirst($v),
        );
    }
    ///devolovemos todos los id de los tags de un post en forma de array
    public function getPostTagsId(): array{
        $tagsPost=[];
        foreach($this->tags as $item){
            $tagsPost[]=$item->id;
        }
        return $tagsPost;
    }
}
