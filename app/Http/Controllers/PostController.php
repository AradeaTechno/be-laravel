<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Helpers\ResponseHelper;
use App\Helpers\RequestHelper;
use App\Models\User;
use App\Models\Post;

use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display list of post.
     */
    public function index(Request $request)
    {
        // PAGINATED POST
        $perPage = $request->query('per_page', 10);
        $post = Post::paginate($perPage);
        return ResponseHelper::create(200, $post, "Post fetch successfully");
    }
    
    /**
     * Display a post.
     */
    public function getById($id){
        $post = Post::find($id);
        // CHECK IS POST EXIST
        if(!$post) return ResponseHelper::create(404);
        return ResponseHelper::create(200, $post);
    }

    /**
     * Create New Post.
     */
    public function store(PostRequest $request)
    {
        $validate = $request->validated();
        $data = RequestHelper::sanitize($validate);
        // CHECK IS USER EXIST
        $user = User::find($data['user_id']);
        if(!$user) return ResponseHelper::create(403, null, "User is not allowed to create a post");
        // SAVE THE POST
        $save = Post::create($data);
        return ResponseHelper::create(201, null, "Post created");
    }   

    /**
     * Update Post.
     */
    public function update(PostUpdateRequest $request, $id){
        // GET POST BY ID
        $post = Post::find($id);
        // IF POST NOT EXIST
        if(!$post) return ResponseHelper::create(404, null, "Post not found");
        // VALIDATION
        $validate = $request->validated();
        $data = RequestHelper::sanitize($validate);

        // PREVENT EMPTY DATA TO BE OVERRIDEN
        if($request->filled('title')) $post->title = $request->title;
        if($request->filled('content')) $post->content = $request->content;
        
        // UPDATE THE POST
        $post->save();
        return ResponseHelper::create(200, null, "Post updated");
    }

    /**
     * Delete Post.
     */
    public function delete($id){
        $post = Post::find($id);
        if(!$post) return ResponseHelper::create(404, null, "Post not found");
        // DELETE POST
        $post->delete();
        return ResponseHelper::create(200, null, "Post deleted");
    }
}
