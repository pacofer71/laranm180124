<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::orderBy('id', 'desc')->paginate(10);
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tags = Tag::select('id', 'nombre')->orderBy('nombre')->get();
        return view('posts.create', compact('tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => ['required', 'string', 'min:3', 'unique:posts,titulo'],
            'contenido' => ['required', 'string', 'min:10'],
            'imagen' => ['nullable', 'image', 'max:2048'],
            'estado' => ['nullable'],
            'tags' => ['required', 'array', 'min:1', 'exists:tags,id']
        ]);
        //Guardo el post
        $post = Post::create(
            [
                'titulo' => $request->titulo,
                'contenido' => $request->contenido,
                'imagen' => ($request->imagen) ? $request->imagen->store('posts') : "posts/default.jpg",
                'estado' => ($request->estado) ? "PUBLICADO" : "BORRADOR",
            ]
        );
        //Le asignamos al post que acabamos de crear los tags
        $post->tags()->attach($request->tags);
        return redirect()->route('posts.index')->with('info', 'Se guardó el Post');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $tagsPost = $post->getPostTagsId();
        $tags = Tag::select('id', 'nombre')->orderBy('nombre')->get();
        return view('posts.edit', compact('post', 'tags', 'tagsPost'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'titulo' => ['required', 'string', 'min:3', 'unique:posts,titulo,' . $post->id],
            'contenido' => ['required', 'string', 'min:10'],
            'imagen' => ['nullable', 'image', 'max:2048'],
            'estado' => ['nullable'],
            'tags' => ['required', 'array', 'min:1', 'exists:tags,id']
        ]);
        $ruta = $post->imagen;
        if ($request->imagen) {
            if (basename($post->imagen) != 'default.jpg') {
                Storage::delete($post->imagen);
            }
            $ruta = $request->imagen->store('posts');
        }
        //Actualizamos el post
        $post->update([
            'titulo' => $request->titulo,
            'contenido' => $request->contenido,
            'imagen' => $ruta,
            'estado' => ($request->estado) ? "PUBLICADO" : "BORRADOR",
        ]);
        //Actualizamos sus etiquetas
        $post->tags()->sync($request->tags);

        return redirect()->route('posts.index')->with('info', 'Se actualizó el Post');


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //Borramos la imagen asociada al post si no es post/default.jpg
        if (basename($post->imagen) != 'default.jpg') {
            Storage::delete($post->imagen);
        }
        $post->delete();
        return redirect()->route('posts.index')->with('info', 'Se borró el Post');
    }
}
