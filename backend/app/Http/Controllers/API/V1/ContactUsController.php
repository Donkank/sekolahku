<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\V1\BaseController as BaseController;
use App\Http\Resources\ContactUsCollection;
use App\Http\Resources\ContactUsResource;
use App\Mail\ContactUsMail;
use App\Models\ContactUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;

class ContactUsController extends BaseController
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'user-access:admin'], ['except' => ['store']]);
    }

    public function index(): JsonResponse
    {
        $mails = ContactUs::latest()->paginate(10);

        return $this->sendResponse(new ContactUsCollection($mails), 'Semua pesan ditampilkan.');
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name'      => ['required'],
            'email'     => ['required', 'email'],
            'message'   => ['required']
        ]);

        if ($validator->fails()) return $this->sendError('Gagal mengirim pesan.', $validator->errors(), 422);

        $mail = ContactUs::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'message'   => $request->message
        ]);

        Mail::to($request->email)->send(new ContactUsMail($mail));

        return $this->sendResponse($mail, 'Pesan berhasil disimpan.');
    }

    public function show(ContactUs $contact): JsonResponse
    {
        if (!session()->has($contact->id)) {
            ContactUs::where('id', $contact->id)->increment('read');
            session()->put($contact->id, 1);
        }

        return $this->sendResponse(new ContactUsResource($contact), 'Pesan berhasil ditampilkan.');
    }

    public function destroy(ContactUs $contact): JsonResponse
    {
        $mail = ContactUs::findOrFail($contact->id);

        $mail->delete();

        return $this->sendResponse($mail, 'Pesan berhasil dihapus.');
    }

    public function restore(string $id): JsonResponse
    {
        $mail = ContactUs::withTrashed()->findOrFail($id);

        $mail->restore();

        return $this->sendResponse($mail, 'Pesan berhasil dipulihkan');
    }

    public function delete(string $id): JsonResponse
    {
        $mail = ContactUs::withTrashed()->findOrFail($id);

        $mail->forceDelete();

        return $this->sendResponse($mail, 'Pesan berhasil dihapus.');
    }

    public function restoreAll(): JsonResponse
    {
        $mail = ContactUs::onlyTrashed();

        $mail->restore();

        return $this->sendResponse($mail, 'Semua pesan berhasil dipulihkan.');
    }

    public function deleteAll(): JsonResponse
    {
        $mail = ContactUs::onlyTrashed();

        $mail->forceDelete();

        return $this->sendResponse($mail, 'Semua pesan berhasil dihapus.');
    }
}
