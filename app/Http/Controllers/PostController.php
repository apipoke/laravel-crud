<?php

namespace App\Http\Controllers;

use App\{Post, Tag, Category};
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('posts.index', [
          'posts'=> Post::latest()->paginate(6),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create', [
          'post' => new Post(),
          'categories' => Category::get(),
          'tags' => Tag::get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {

        $request->validate([
          'thumbnail' => 'image|mimes:jpg,jpeg,png,svg|max:2048'
        ]);

        $attr = $request->all();

        $slug= \Str::slug(request()->title);
        $attr['slug'] = $slug;

        $thumbnail = request()->file('thumbnail') ? request()->file('thumbnail')->store("images/posts") : null;

        $attr['category_id'] = request('category');
        $attr['thumbnail'] = $thumbnail;

        $post = auth()->user()->posts()->create($attr);

        $post->tags()->attach(request('tags'));

        session()->flash('success', 'The post was created');

        return redirect('posts');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $posts = Post::where('category_id', $post->category_id)->latest()->limit(6)->get();
        return view('posts.show', compact('post', 'posts'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('posts.edit', [
          'post' => $post,
          'categories' => Category::get(),
          'tags' => Tag::get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, Post $post)
    {
      $request->validate([
        'thumbnail' => 'image|mimes:jpg,jpeg,png,svg|max:2048'
      ]);

      $this->authorize('update', $post);

      if (request()->file('thumbnail')) {
          \Storage::delete($post->thumbnail);
          $thumbnail = request()->file('thumbnail')->store("images/posts");
      } else {
          $thumbnail = $post->thumbnail;
      }

      $attr = $request->all();
      $attr['category_id'] = request('category');
      $attr['thumbnail'] = $thumbnail;

      $post->update($attr);
      $post->tags()->sync(request('tags'));

      session()->flash('success', 'The post was updated');

      return redirect('posts');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {

        $this->authorize('delete', $post);

        \Storage::delete($post->thumbnail);

        $post->tags()->detach();
        $post->delete();

        session()->flash('success', 'The post was deleted');

        return redirect('posts');

    }



}
