<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\V1\BaseController as BaseController;
use App\Http\Resources\QuoteCollection;
use App\Http\Resources\QuoteResource;
use App\Models\Quote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;

class QuoteController extends BaseController
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'user-access:admin'], ['except' => ['index']]);
    }

    public function index(): JsonResponse
    {
        $quotes = Quote::latest()->paginate(10);

        return $this->sendResponse(new QuoteCollection($quotes), 'Semua quote ditampilkan.');
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'text'     => ['required'],
            'author'    => ['required', 'max:255']
        ]);

        if ($validator->fails()) return $this->sendError('Gagal menyimpan data.', $validator->errors(), 422);

        $quote = Quote::create([
            'text'     => $request->text,
            'author'    => $request->author
        ]);

        return $this->sendResponse($quote, 'Quote berhasil ditambah.');
    }

    public function show(Quote $quote)
    {
        $data = Quote::findOrFail($quote->id);

        return $this->sendResponse(new QuoteResource($data), 'Quote berhasil ditampilkan.');
    }

    public function update(Request $request, Quote $quote)
    {
        $validator = Validator::make($request->all(), [
            'text'     => ['required'],
            'author'    => ['required', 'max:255']
        ]);

        if ($validator->fails()) return $this->sendError('Gagal update data.', $validator->errors(), 422);

        $data = Quote::findOrFail($quote->id);

        $data->update([
            'text'     => $request->text,
            'author'    => $request->author
        ]);

        return $this->sendResponse($data, 'Quote berhasil diubah.');
    }

    public function destroy(Quote $quote)
    {
        $data = Quote::findOrFail($quote->id);

        $data->delete();

        return $this->sendResponse($data, 'Quote berhasil dihapus.');
    }
}
