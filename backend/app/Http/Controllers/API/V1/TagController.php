<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\V1\BaseController as BaseController;
use App\Http\Resources\TagCollection;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;

class TagController extends BaseController
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'user-access:admin'], ['except' => ['index']]);
    }

    public function index(): JsonResponse
    {
        $tags = Tag::paginate(10);

        return $this->sendResponse(new TagCollection($tags), 'Semua penanda ditampilkan.');
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'tag'  => ['required']
        ]);

        if ($validator->fails()) return $this->sendError('Gagal menyimpan data.', $validator->errors(), 422);

        $slug = $this->generateTagName($request->tag);

        $tag = Tag::create([
            'name' => $slug
        ]);

        return $this->sendResponse($tag, 'Penanda berhasil ditambahkan.');
    }

    public function show(Tag $tag): JsonResponse
    {
        $data = Tag::findOrFail($tag->id);

        return $this->sendResponse(new TagResource($data), 'Penanda berhasil ditampilkan.');
    }

    public function update(Request $request, Tag $tag): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'tag'  => ['required']
        ]);

        if ($validator->fails()) return $this->sendError('Gagal update data.', $validator->errors(), 422);

        $slug = $this->generateTagName($request->tag);

        $data = Tag::findOrFail($tag->id);

        $data->update([
            'name' => $slug
        ]);

        return $this->sendResponse($data, 'Penanda berhasil diperbaharui.');
    }

    public function destroy(Tag $tag): JsonResponse
    {
        $data = Tag::findOrFail($tag->id);

        $data->delete();

        return $this->sendResponse($data, 'Penanda berhasil dihapus.');
    }
}
