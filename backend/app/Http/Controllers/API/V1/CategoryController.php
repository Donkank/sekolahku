<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\V1\BaseController as BaseController;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;

class CategoryController extends BaseController
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'user-access:admin'], ['except' => ['index']]);
    }

    public function index(): JsonResponse
    {
        $categories = Category::paginate(10);

        return $this->sendResponse(new CategoryCollection($categories), 'Semua kategory ditampilkan.');
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'category'  => ['required']
        ]);

        if ($validator->fails()) return $this->sendError('Gagal menyimpan data.', $validator->errors(), 422);

        $slug = $this->generateTagName($request->category);

        $category = Category::create([
            'category'  => $request->category,
            'slug'      => $slug
        ]);

        return $this->sendResponse($category, 'Kategori berhasil ditambah.');
    }

    public function show(Category $category): JsonResponse
    {
        $data = Category::findOrFail($category->id);

        return $this->sendResponse(new CategoryResource($data), 'Kategori berhasil ditampilkan.');
    }

    public function update(Request $request, Category $category): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'category'  => ['required']
        ]);

        if ($validator->fails()) return $this->sendError('Gagal update data.', $validator->errors(), 422);

        $slug = $this->generateTagName($request->category);

        $data = Category::findOrFail($category->id);

        $data->update([
            'category' => $request->category,
            'slug' => $slug
        ]);

        return $this->sendResponse($data, 'Kategori berhasil diubah.');
    }

    public function destroy(Category $category): JsonResponse
    {
        $data = Category::findOrFail($category->id);

        $data->delete();

        return $this->sendResponse($data, 'Kategori berhasil dihapus.');
    }
}
