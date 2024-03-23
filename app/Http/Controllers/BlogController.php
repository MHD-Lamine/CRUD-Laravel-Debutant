<?php

namespace App\Http\Controllers;
use App\Http\Requests\BlogFilterRequest;
use App\Http\Requests\createPostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Hash;
use Illuminate\Contracts\Pagination\Paginator;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class BlogController extends Controller

{
    public function edit(Post $post){

        return view("blog.edit", [
            "post" => $post,
            'categories' => Category::select('id', 'name')->get(),
            'tags'=> Tag::select('id','name')->get(),
        ]);

    }

    public function update(Post $post, createPostRequest $request){

        /* $data =$request->validated();

        /**@var UploadedFile|null $image
        $image = $request->validated('image');
        // $image->store('blog','public');

        if($image!=null && !$image->getError()){
            $imagePath=$image->store('blog','public');
            //dd($imagePath);
            $data['image']= $imagePath;
        } */

        //$data['image']=$request->validated('image')->store('blog','public');

        $post->update($this->dataExtract($post, $request));
        $post->tags()->sync($request->validated('tags'));
        return redirect()->route("blog.show",[
            'slug'=>$post->slug,
            'id'=>$post->id
            ])->with("success","modification reussir");
    }

    private function dataExtract(Post $post, createPostRequest $request): array
    {

        $data =$request->validated();

        /**@var UploadedFile|null $image */
        $image = $request->validated('image');
        // $image->store('blog','public');
        if ($image==null | $image->getError()){
            return $data;
        }

        if ($post->image){

            Storage::disk('public')->delete($post->image);

        }

        $imagePath=$image->store('blog','public');
            //dd($imagePath);
        $data['image']= $imagePath;
        return $data;

    }

    public function create(): View{
        //dd(session()->all());
        $post = new Post();
        return view("blog.create", [
            "post"=> $post,
            'categories' => Category::select('id', 'name')->get(),
            'tags'=> Tag::select('id','name')->get(),
        ]);
    }

    public function store(createPostRequest $request){
        /*$post = Post::create([
            "title"=> $request->input("title"),
            "slug"=> \Str::slug($request->input("title")),
            "content"=> $request->input("content"),

        ]);*/

        $post = new Post();
        $post = Post::create($this->dataExtract($post, $request));
        $post->tags()->sync($request->validated('tags'));

        return redirect()->route("blog.show",['slug'=>$post->slug, 'id'=>$post->id])->with("success","enregistrement reussir");
    }
    public function index(): View{
        //
        //
        // User::create([
        //     "name"=> "mohamed",
        //     "email"=> "mhd@gmail.com",
        //     "password"=> Hash::make("0000"),
        // ]);

        //$post = Post::has('tags','>=', 1);//permet de trouver tout les post avec au mon un tag
        //$tags= $post->has('tags','>=', 1);
       /*  $tags = $post->tags()->detach(2);// permet de detacher avec de tag mais on peut utiliser la methode sync(['id1','id2'.....])
       $tags=$post->tags()->where('name','=','tag 2')->get();
        $post->tag()->createMany([[
            "name"=> " tag 1",
        ],[
            "name"=> "tag 2",
        ]]);*/



        //$category = Category::find(1);


        /*$post = Post::with('category')->get();
        foreach ($post as $key ) {
            $category=$key->category?->name;
        }*/

        $posts = Post::with('tags', 'category')->paginate(1);
        return view('blog.index', [
            'posts'=>$posts]);
    }
    public function show(string $slug, string $id): RedirectResponse | View{
        $post = Post::findOrFail($id);
        if($post->slug != $slug){
            return to_route("blog.show", ['slug'=>$post->slug, 'id'=>$post->id]);
        }
        return view('blog.show', [
            'post'=>$post,
        ]);
    }
}
