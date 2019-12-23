<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Faker\Factory;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return \App\Post::with('author')->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $post = new \App\Post();
        $faker = Factory::create();

        $author =  \App\Author::orderBy(\DB::raw('RAND()'))->first();
        $post->title = $faker->sentence(7);
        $post->content = $faker->text(100);
        $post->author_id = $author->id ?? 0;
        $post->save();

        return $post;
    }
}
