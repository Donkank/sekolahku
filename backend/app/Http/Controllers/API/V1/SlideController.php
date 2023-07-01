<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\V1\BaseController as BaseController;
use App\Http\Resources\SlideCollection;
use App\Http\Resources\SlideResource;
use App\Models\Slide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;

class SlideController extends BaseController
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'user-access:admin'], ['except' => ['index']]);
    }

    public function index(): JsonResponse
    {
        $images = Slide::latest()->paginate(9);

        return $this->sendResponse(new SlideCollection($images), 'Semua gambar berhasil ditampilkan.');
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'images'    => ['required'],
            'images.*'  => ['required', 'image', 'mimes:jpg,png,jpeg,gif,svg', 'max:2048'],
            'title'     => ['required']
        ]);

        if ($validator->fails()) return $this->sendError('Gagal menyimpan data.', $validator->errors(), 500);

        $images = array();

        $imagePath = storage_path('app/public/slides/');

        if ($request->images) {
            foreach ($request->images as $key => $image) {
                $imageName = time() . rand(100, 999) . '.' . $image->extension();

                $image->move($imagePath, $imageName);

                array_push($images, $imageName);
            }
        }

        foreach ($images as $key => $image) {
            Slide::create([
                'title'   => $request->title,
                'url'     => $image,
                'alt'     => $request->alt,
                'desc'    => $request->desc
            ]);
        }

        return $this->sendResponse($images, 'Anda telah berhasil mengunggah gambar.');
    }

    public function show(Slide $slide): JsonResponse
    {
        $image = Slide::findOrFail($slide->id);

        return $this->sendResponse(new SlideResource($image), 'Gambar berhasil ditampilkan.');
    }

    public function update(Request $request, Slide $slide): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'image' => ['nullable', 'image', 'mimes:jpg,png,jpeg,gif,svg', 'max:2048'],
            'title' => ['required'],
            'alt'   => ['required'],
            'desc'  => ['required']
        ]);

        if ($validator->fails()) return $this->sendError('Gagal update data.', $validator->errors(), 500);

        $image = Slide::findOrFail($slide->id);

        $imageName = $image->url;

        $title = $image->title;

        if ($request->image) {

            $image_path = storage_path('app/public/slides/');

            if (file_exists($image_path . $imageName)) {
                unlink($image_path . $imageName);
            }

            $file = $request->file('image');

            $imageName = time() . rand(100, 999) . '.' . $file->extension();

            $file->move($image_path, $imageName);
        }

        if ($request->title) $title = $request->title;

        $image->update([
            'title'   => $title,
            'url'     => $imageName,
            'alt'     => $request->alt,
            'desc'    => $request->desc
        ]);

        return $this->sendResponse($image, 'Gambar berhasil diubah.');
    }

    public function destroy(Slide $slide): JsonResponse
    {
        $image = Slide::withTrashed()->findOrFail($slide->id);

        $image->delete();

        return $this->sendResponse($image, 'Gambar berhasil dinonaktifkan.');
    }

    public function restore(string $id): JsonResponse
    {
        $data = Slide::withTrashed()->findOrFail($id);

        $data->restore();

        return $this->sendResponse($data, 'Gambar berhasil dipulihkan');
    }

    public function delete(string $id): JsonResponse
    {
        $image = Slide::withTrashed()->findOrFail($id);

        $image_path = storage_path('app/public/slides/' . $image->url);

        if (file_exists($image_path)) {

            $image->forceDelete();

            unlink($image_path);

            return $this->sendResponse($image, 'Gambar berhasil dihapus.');
        }

        return $this->sendError('File tidak ditemukan', $image_path, 404);
    }

    public function restoreAll(): JsonResponse
    {
        $data = Slide::onlyTrashed();
        $data->restore();

        return $this->sendResponse($data, 'Semua quote berhasil dipulihkan.');
    }

    public function deleteAll(): JsonResponse
    {
        $images = Slide::onlyTrashed()->get();

        if (!$images) return $this->sendError('Data kosong.', $images);

        $array_images = array();

        foreach ($images as $image) {

            $image_path = storage_path('app/public/slides/' . $image->url);

            if (file_exists($image_path)) {

                unlink($image_path);

                $image->forceDelete();

                array_push($array_images, "Success : " . $image->url);
            } else {

                array_push($array_images, "Error : " . $image->url . " not found.");
            }
        }
        return $this->sendResponse($array_images, 'Gambar berhasil dihapus.');
    }
}
