<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\V1\BaseController as BaseController;
use App\Http\Resources\SubscriberCollection;
use App\Http\Resources\SubscriberResource;
use App\Mail\SubscribeMail;
use App\Models\Subscribe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;

class SubscribeController extends BaseController
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'user-access:admin'], ['except' => ['store', 'destroy']]);
    }

    public function index(Request $request): JsonResponse
    {
        $subscribers = Subscribe::latest();

        if ($request->get('status') == 'archived') $subscribers = $subscribers->onlyTrashed();

        $subscribers = $subscribers->paginate(10);

        return $this->sendResponse(new SubscriberCollection($subscribers), 'Semua pengikut berhasil ditampilkan.');
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email', 'unique:subscribers'],
        ]);

        if ($validator->fails()) return $this->sendError('Gagal menyimpan data.', $validator->errors(), 422);

        $subscriber = Subscribe::create([
            'email' => $request->email
        ]);

        $mailData = [
            'email' => $request->email,
            'token' => base64_encode($subscriber->id)
        ];

        Mail::to($request->email)->send(new SubscribeMail($mailData));

        return $this->sendResponse($subscriber, 'Anda telah menjadi pelanggan, cek email Anda secara berkala.');
    }

    public function show(Subscribe $subscribe): JsonResponse
    {
        $data = Subscribe::findOrFail($subscribe->id);

        return $this->sendResponse(new SubscriberResource($data), 'Pengikut berhasil ditampilkan.');
    }

    public function destroy(Subscribe $subscribe): JsonResponse
    {
        $data = Subscribe::findOrFail($subscribe->id);

        $data->delete();

        return $this->sendResponse($data, 'Anda telah berhenti berlangganan.');
    }

    public function restore(string $id): JsonResponse
    {
        $subscriber = Subscribe::withTrashed()->findOrFail($id);

        $subscriber->restore();

        return $this->sendResponse($subscriber, 'Pengikut berhasil dipulihkan');
    }

    public function delete(string $id): JsonResponse
    {
        $subscriber = Subscribe::withTrashed()->findOrFail($id);

        $subscriber->forceDelete();

        return $this->sendResponse($subscriber, 'Pengikut berhasil dihapus.');
    }

    public function restoreAll(): JsonResponse
    {
        $subscriber = Subscribe::onlyTrashed();

        $subscriber->restore();

        return $this->sendResponse($subscriber, 'Semua pengikut berhasil dipulihkan.');
    }

    public function deleteAll(): JsonResponse
    {
        $subscriber = Subscribe::onlyTrashed();

        $subscriber->forceDelete();

        return $this->sendResponse($subscriber, 'Semua pengikut berhasil dihapus.');
    }
}
