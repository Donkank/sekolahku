<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\V1\BaseController as BaseController;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends BaseController
{
    public function __construct()
    {
        $this->middleware(['auth:api'], ['except' => ['login', 'register']]);
    }

    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'string', 'max:255', 'email', 'unique:users'],
            'password'  => ['required', 'string', 'confirmed'],
        ]);

        if ($validator->fails()) return $this->sendError('Gagal melakukan registrasi.', $validator->errors(), 422);

        if (!$request->checkbox) return $this->sendError('Uncheckbox', ['checkbox' => 'Checkbox harap dicentang.'], 406);

        $user = User::create([
            'name'      => $request->name,
            'email'     => Str::lower($request->email),
            'password'  => Hash::make($request->password)
        ]);

        return $this->sendResponse($user, 'Penguna berhasil terdaftar.', 201);
    }

    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'user'         => ['required'],
            'password'      => ['required']
        ]);

        if ($validator->fails()) return $this->sendError('Gagal login!. Inputan kosong atau tidak sesuai.', $validator->errors(), 422);

        $fieldType = filter_var($request->user, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        if (!$token = auth()->guard('api')->attempt([

            $fieldType => Str::lower($request->user), 'password' => $request->password
        ])) {

            return $this->sendError('email atau password salah.', [], 401);
        }

        return $this->sendResponse($this->respondWithToken($token), 'Pengguna berhasil login.');
    }

    public function me(): JsonResponse
    {
        return $this->sendResponse(new UserResource(auth()->guard('api')->user()), 'Data Pengguna berhasil ditampilkan.');
    }

    public function logout(): JsonResponse
    {
        $user = auth()->guard('api')->logout();

        return $this->sendResponse($user, 'Pengguna berhasil keluar.');
    }

    public function refresh(): JsonResponse
    {

        return $this->sendResponse(JWTAuth::refresh(), 'Token telah diperbaharui.');
    }

    protected function respondWithToken($token)
    {
        $data = [
            'refresh_token'  => $token,
            'user'           => new UserResource(auth()->user()),
            'expires_in'     => JWTAuth::factory()->getTTL() * 60
        ];

        return $data;
    }
}
