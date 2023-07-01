<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\V1\BaseController as BaseController;
use App\Http\Resources\VideoCollection;
use App\Http\Resources\VideoResource;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;

class VideoController extends BaseController
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'user-access:admin'], ['except' => ['index']]);
    }

    public function index(): JsonResponse
    {
        $videos = Video::latest()->paginate(4);

        return $this->sendResponse(new VideoCollection($videos), 'Semua video berhasil ditampilkan.');
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title'  => ['required', 'max:255'],
            'desc'   => ['required'],
            'url'    => ['required']
        ]);

        if ($validator->fails()) return $this->sendError('Gagal menyimpan data.', $validator->errors(), 422);

        $video = Video::create([
            'title'  => $request->title,
            'desc'   => $request->desc,
            'url'    => $request->url
        ]);

        return $this->sendResponse($video, 'Video berhasil ditambah.');
    }

    public function show(Video $video): JsonResponse
    {
        $data = Video::findOrFail($video->id);

        return $this->sendResponse(new VideoResource($data), 'Video berhasil ditampilkan.');
    }

    public function update(Request $request, Video $video): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title'  => ['required', 'max:255'],
            'url'    => ['required'],
            'desc'   => ['required']
        ]);

        if ($validator->fails()) return $this->sendError('Gagal update video.', $validator->errors(), 422);

        $data = Video::findOrFail($video->id);

        $data->update([
            'title'  => $request->title,
            'url'    => $request->url,
            'desc'   => $request->desc
        ]);

        return $this->sendResponse($data, 'Video berhasil diubah.');
    }

    public function destroy(Video $video): JsonResponse
    {
        $data = Video::findOrFail($video->id);
        $data->delete();

        return $this->sendResponse($data, 'Video berhasil dihapus.');
    }

    public function restore(string $id): JsonResponse
    {
        $video = Video::withTrashed()->findOrFail($id);

        $video->restore();

        return $this->sendResponse($video, 'Pengguna berhasil dipulihkan');
    }

    public function delete(string $id): JsonResponse
    {
        $video = Video::withTrashed()->findOrFail($id);

        $video->forceDelete();

        return $this->sendResponse($video, 'Pengguna berhasil dipulihkan');
    }

    public function restoreAll(): JsonResponse
    {
        $videos = Video::onlyTrashed();
        $videos->restore();

        return $this->sendResponse($videos, 'Semua pengguna berhasil dipulihkan.');
    }

    public function deleteAll(): JsonResponse
    {
        $videos = Video::onlyTrashed();
        $videos->forceDelete();

        return $this->sendResponse($videos, 'Semua pengguna berhasil dihapus.');
    }
}
