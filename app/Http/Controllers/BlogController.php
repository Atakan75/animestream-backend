<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Services\FileService;

use App\Models\Blog;
use App\Http\Resources\BlogResource;
use App\Http\Requests\BlogStoreRequest;
use App\Http\Requests\BlogThumbnailRequest;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::all();
        return response_success([
            'message' => 'Blogs retrieved successfully',
            'blogs' => BlogResource::collection($blogs)
        ]);
    }

    public function show($slug)
    {
        $blog = Blog::where('slug', $slug)->first();
        if (!$blog) {
            return response_error([
               'message' => 'Blog not found'
            ], 404);
        }
        return response_success([
            'message' => 'Blog retrieved successfully',
            'blog' => new BlogResource($blog)
        ]);
    }

    public function store(BlogStoreRequest $request)
    {
        $blog = Blog::create([
            'specs' => 1,
            'user_id' => $request->user()->id,
            'author' => $request->user()->name,
            'slug' => Str::slug($request->title),
            'title' => $request->title,
            'meta_title' => $request->meta_title,
            'category' => $request->category,
            'publishDate' => $request->publishDate,
            'meta_description' => $request->meta_description,
            'description' => $request->description,
        ]);
        return response_success([
           'message' => 'Blog created successfully',
            'blog' => new BlogResource($blog)
        ]);
    }

    public function setBlogThumbnail($id, BlogThumbnailRequest $request, FileService $fileService)
    {
        $blog = Blog::find($id);
        $blog->thumbnail()->delete();

        $fileData = $fileService->uploadBlogThumbnail(
            $request->file('blog_thumbnail'),
            $blog->id
        );

        $thumbnail = $blog->thumbnail()->create($fileData);

        return response_success([
            'message' => 'Blog Thumbnail başarıyla yüklendi',
            'thumbnail'  => $thumbnail,
        ], 200);
    }
}
