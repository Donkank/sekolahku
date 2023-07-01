<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\V1\BaseController as BaseController;
use App\Http\Resources\CommentCollection;
use App\Http\Resources\CommentReplyResource;
use App\Models\Comment;
use App\Models\PostComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;

class CommentController extends BaseController
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'user-access:admin'], ['except' => ['store', 'update', 'destroy']]);
    }

    public function index(): JsonResponse
    {
        $comments = Comment::latest()->paginate(10);

        return $this->sendResponse(new CommentCollection($comments), 'Semua komentar berhasil ditampilkan.');
    }

    public function store(Request $request, string $id): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name'  => ['required'],
            'email' => ['required', 'email'],
            'body'  => ['required']
        ]);

        if ($validator->fails()) return $this->sendError('Gagal menyimpan komentar.', $validator->errors(), 422);

        $parent_id = 0;

        if (!is_null($request->parent_id)) {
            $parent_id = $request->parent_id;
        }

        $comment = Comment::create([
            'parent_id' => $parent_id,
            'name'      => $request->name,
            'email'     => $request->email,
            'website'   => $request->website,
            'body'      => $request->body
        ]);

        $sync = PostComment::create([
            'post_id'       => $id,
            'comment_id'    => $comment->id
        ]);

        return $this->sendResponse($comment, 'Komentar berhasil disimpan.');
    }

    public function show(Comment $comment): JsonResponse
    {
        $data = Comment::findOrFail($comment->id);

        return $this->sendResponse(new CommentReplyResource($data), 'Komentar berhasil ditampilkan.');
    }

    public function update(Request $request, Comment $comment): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'body'  => ['required']
        ]);

        if ($validator->fails()) return $this->sendError('Gagal mengupdate komentar.', $validator->errors(), 422);

        $data = Comment::findOrFail($comment->token);

        $data->update([
            'body'      => $request->body
        ]);

        return $this->sendResponse($data, 'Komentar berhasil diubah.');
    }

    public function destroy(Comment $comment): JsonResponse
    {
        $data = Comment::findOrFail($comment->token);

        $data->delete();

        return $this->sendResponse($data, 'Komentar berhasil dinonaktifkan.');
    }

    public function restore(string $id): JsonResponse
    {
        $comment = Comment::withTrashed()->findOrFail($id);

        $comment->restore();

        return $this->sendResponse($comment, 'Komentar berhasil dipulihkan');
    }

    public function delete(string $id): JsonResponse
    {
        $comment = Comment::withTrashed()->findOrFail($id);

        $comment->forceDelete();

        return $this->sendResponse($comment, 'Komentar berhasil dihapus.');
    }

    public function restoreAll(): JsonResponse
    {
        $comment = Comment::onlyTrashed();

        $comment->restore();

        return $this->sendResponse($comment, 'Semua komentar berhasil dipulihkan.');
    }

    public function deleteAll(): JsonResponse
    {
        $comment = Comment::onlyTrashed();

        $comment->forceDelete();

        return $this->sendResponse($comment, 'Semua komentar berhasil dihapus.');
    }
}
