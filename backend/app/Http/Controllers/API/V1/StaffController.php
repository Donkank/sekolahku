<?php

namespace App\Http\Controllers\API\V1;

use App\Exports\StaffExport;
use App\Http\Controllers\API\V1\BaseController as BaseController;
use App\Imports\StaffImport;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\JsonResponse;

class StaffController extends BaseController
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'user-access:admin']);
    }

    public function index()
    {
        $staffs = Staff::all();

        return $this->sendResponse($staffs, 'Semua staff berhasil ditampilkan.');
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Staff $staff)
    {
        //
    }

    public function update(Request $request, Staff $staff)
    {
        //
    }

    public function destroy(Staff $staff)
    {
        //
    }

    public function import(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'excel'    => ['required', 'file', 'max:1024'],
        ]);

        if ($validator->fails()) return $this->sendError('Gagal import file', $validator->errors(), 500);

        $staffs =  Excel::import(new StaffImport, request()->file('excel'));

        if (!$staffs) return $this->sendError('error', 'terjadi kesalaha, mohon cek file anda, atau maksimal list data adalah 25.', 422);

        return $this->sendResponse($staffs, 'Data berhasil di import ke database.');
    }

    public function export()
    {
        return Excel::download(new StaffExport, rand(10000000, 99999999) . '.xlsx');
    }
}
