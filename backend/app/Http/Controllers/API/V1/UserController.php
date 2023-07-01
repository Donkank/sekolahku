<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\V1\BaseController as BaseController;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserController extends BaseController
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'user-access:admin']);
    }

    public function index(Request $request): JsonResponse
    {
        $users = User::latest();

        if ($request->get('status') == 'archived') $users = $users->onlyTrashed();

        $users = $users->filter(request(['search']))->paginate(10)->withQueryString();

        return $this->sendResponse(new UserCollection($users), 'Semua pengguna berhasil ditampilkan.');
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name'                  => ['required', 'alpha_dash'],
            'email'                 => ['required', 'unique:users'],
            'password'              => ['required', 'max:255', 'confirmed', 'min:6'],
        ]);

        if ($validator->fails()) return $this->sendError('Gagal menyimpan data.', $validator->errors(), 422);

        $user = User::create([
            'name'              => $request->name,
            'email'             => Str::lower($request->email),
            'password'          => Hash::make($request->password),
            'staff_id'          => $request->profile_id,
            'email_verified_at' => now(),
            'type'              => $request->type,
            'role'              => $request->role
        ]);

        return $this->sendResponse($user, 'Pengguna berhasil ditambahkan.', 201);
    }

    public function show(User $user): JsonResponse
    {
        $data = User::findOrFail($user->id);

        return $this->sendResponse(new UserResource($data), 'Pengguna berhasil ditampilkan.');
    }

    public function update(Request $request, User $user): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name'         => ['required', 'alpha_dash'],
            'email'        => ['required', Rule::unique('users')->ignore($user->id)],
            'type'         => ['required']
        ]);

        if ($validator->fails()) return $this->sendError('Gagal update data.', $validator->errors(), 422);

        $data = User::findOrFail($user->id);

        $password = Hash::make($request->password);

        if (!$password) $password = $data->password;

        $data->update([
            'name'            => $request->name,
            'password'        => $password,
            'email'           => Str::lower($request->email),
            'staff_id'        => $request->profile_id,
            'type'            => $request->type,
            'role'            => $request->role
        ]);

        return $this->sendResponse($data, 'Penguna berhasil diubah.');
    }

    public function destroy(User $user): JsonResponse
    {
        $data = User::findOrFail($user->id);

        $data->delete();

        return $this->sendResponse($data, 'Pengguna berhasil dinonaktifkan.');
    }

    public function restore(string $id): JsonResponse
    {
        $user = User::withTrashed()->findOrFail($id);

        $user->restore();

        return $this->sendResponse($user, 'Pengguna berhasil dipulihkan');
    }

    public function delete(string $id): JsonResponse
    {
        $user = User::withTrashed()->findOrFail($id);

        $user->forceDelete();

        return $this->sendResponse($user, 'Pengguna berhasil dihapus.');
    }

    public function restoreAll(): JsonResponse
    {
        $user = User::onlyTrashed();
        $user->restore();

        return $this->sendResponse($user, 'Semua pengguna berhasil dipulihkan.');
    }

    public function deleteAll(): JsonResponse
    {
        $user = User::onlyTrashed();
        $user->forceDelete();

        return $this->sendResponse($user, 'Semua pengguna berhasil dihapus.');
    }
}
