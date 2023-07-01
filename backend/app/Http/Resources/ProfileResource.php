<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'nama'              => $this->nama,
            'gelar_depan'       => $this->gelar_depan,
            'gelar_belakang'    => $this->gelar_belakang,
            'telp'              => $this->telp,
            'sekolah'           => $this->sekolah,
            'jabatan'           => $this->jabatan,
            'bio'               => $this->bio,
            'avatar'            => asset('storage/avatar/' . $this->avatar)
        ];
    }
}
