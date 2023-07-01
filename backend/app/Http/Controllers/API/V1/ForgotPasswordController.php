<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\V1\BaseController as BaseController;
use App\Mail\ForgotPasswordMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;

class ForgotPasswordController extends BaseController
{
    public function forgetPassword(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email'        => ['required'],
        ]);

        if ($validator->fails()) return $this->sendError('Email kosong atau tidak valid', $validator->errors(), 422);

        $user = User::where('email', $request->email)->get();

        if (!$user) return $this->sendError('error', 'Akun tidak ditemukan.');

        $token = $this->generateToken();

        DB::table('password_resets')->insert([
            'email'         => $request->email,
            'token'         => $token,
            'created_at'    => now()
        ]);

        $mail = [
            'name'      => $request->email,
            'email'     => $request->email,
            'token'     => $token
        ];

        Mail::to($request->email)->send(new ForgotPasswordMail($mail));

        return $this->sendResponse($request->email, 'Token telah dikirim ke alamat email.');
    }

    public function resetPassword(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email'                 => ['required'],
            'password'              => ['required', 'string', 'min:6', 'confirmed'],
            'password_confirmation' => ['required']
        ]);

        if ($validator->fails()) return $this->sendError('Gagal menyimpan data.', $validator->errors(), 422);

        $updatePassword = DB::table('password_resets')->where([
            'email'  => $request->email,
            'token'  => $request->token
        ]);

        if (!$updatePassword) return $this->sendError('error', 'Invalid token!', 422);

        DB::table('password_resets')->where(['email' => $request->email])->delete();

        return $this->sendResponse($request->email, 'Password telah berhasil di perbaharui.');
    }
}
