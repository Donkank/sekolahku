<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Staff extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $dates = ["tanggal_lahir", "tanggal_cpns", "tmt_pengangkatan", "tmt_pns", "deleted_at"];

    protected $fillable = [
        "nama", "nuptk", "jk", "tempat_lahir", "tanggal_lahir", "nip", "status_kepegawaian", "jenis_ptk", "agama", "alamat_jalan", "rt", "rw", "nama_dusun", "nama_desa_kelurahan", "kecamatan", "kode_pos", "telepon", "hp", "email", "tugas_tambahan", "sk_cpns", "tanggal_cpns", "sk_pengangkatan", "tmt_pengangkatan", "lembaga_pengangkatan", "pangkat_id", "sumber_gaji", "nama_ibu_kandung", "status_perkawinan", "nama_suami_istri", "nip_suami_istri", "pekerjaan_suami_istri", "tmt_pns", "lisensi_kepala_sekolah", "diklat_kepengawasan", "keahlian_braille", "keahlian_bahasa_isyarat", "npwp", "nama_wajib_pajak", "kewarganegaraan_id", "bank", "nomor_rekening", "rekening_atas_nama", "nik", "no_kk", "karpeg", "karis_karsu", "lintang", "bujur", "nuks", "induk"
    ];
}
