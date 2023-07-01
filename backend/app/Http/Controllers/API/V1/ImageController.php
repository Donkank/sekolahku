<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class ImageController extends Controller
{
    public function uploadImage(Request $request): JsonResponse
    {
        $imagePath = storage_path('app/public/posts/');

        if ($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . rand(100, 999) . '.' . $extension;

            $request->file('upload')->move($imagePath, $fileName);

            $url = asset('storage/posts/' . $fileName);

            return response()->json(['fileName' => $fileName, 'uploaded' => 1, 'url' => $url]);
        }
    }
}
