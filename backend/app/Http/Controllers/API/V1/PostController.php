<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\V1\BaseController as BaseController;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostShowResource;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;

class PostController extends BaseController
{
    public function index(): JsonResponse
    {
        $posts = Post::latest()->filter(request(['search', 'category', 'tags', 'author']))->paginate(5)->withQueryString();

        return $this->sendResponse(new PostCollection($posts), 'Semua artikel berhasil ditampilkan.');
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title'         => ['required', 'min:10', 'unique:posts'],
            'category_id'   => ['required'],
            'tags'          => ['required'],
            'tags.*'        => ['required'],
            'body'          => ['required']
        ]);

        if ($validator->fails()) return $this->sendError('Gagal menyimpan data.', $validator->errors(), 422);

        $imagePath = storage_path('app/public/posts/');

        $content = $request->body;

        /* Editor convert Start */

        /* Editor convert End */

        $post = Post::create([
            'user_id'       => $request->user_id,
            'title'         => $request->title,
            'slug'          => $this->generateTagName($request->title),
            'headline'      => $this->getExcerpt($request->body),
            'body'          => $content,
            'category_id'   => $request->category_id,
        ]);

        //$post->images()->sync($data_image);

        $id_tags = [];

        if ($request->tags) {
            foreach ($request->tags as $tag) {
                $name = self::generateTagName($tag);


                $newTag = Tag::firstOrCreate([
                    'name' => $name,
                ]);

                $id_tags[] = $newTag->id;
            }
        }

        $post->tags()->sync($id_tags);

        if (!$post) return $this->sendError('error', 'Tidak dapat membuat artikel.', 422);

        return $this->sendResponse($post, 'Anda telah berhasil membuat artikel baru.');
    }

    public function show(Post $post): JsonResponse
    {
        if (!session()->has($post->id)) {
            Post::where('id', $post->id)->increment('views');
            session()->put($post->id, 1);
        }

        return $this->sendResponse(new PostShowResource($post), 'Artikel berhasil ditampilkan');
    }

    public function update(Request $request, Post $post)
    {
        //
    }

    public function destroy(Post $post): JsonResponse
    {
        $data = Post::findOrFail($post->id);

        $data->delete();

        if (!$data) return $this->sendError('error', 'Tidak dapat menghapus artikel.');

        return $this->sendResponse($data, 'Anda telah berhasil menghapus artikel.');
    }
}
