<?php

namespace App\Imports;

use App\Models\Staff;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StaffImport implements ToModel, WithHeadingRow
{
    public $data;

    public function __construct()
    {
        $this->data = collect();
    }

    public function model(array $row)
    {
        $staff = Staff::firstOrCreate([
            "nama"                      => $row['nama'],
            "nuptk"                     => $row['nuptk'],
            "jk"                        => $row['jk'],
            "tempat_lahir"              => $row['tempat_lahir'],
            "tanggal_lahir"             => $this->dateToTimeStamp($row['tanggal_lahir']),
            "nip"                       => $row['nip'],
            "status_kepegawaian"        => $row['status_kepegawaian'],
            "jenis_ptk"                 => $row['jenis_ptk'],
            "agama"                     => $row['agama'],
            "alamat_jalan"              => $row['alamat_jalan'],
            "rt"                        => $row['rt'],
            "rw"                        => $row['rw'],
            "nama_dusun"                => $row['nama_dusun'],
            "nama_desa_kelurahan"       => $row['nama_desa_kelurahan'],
            "kecamatan"                 => $row['kecamatan'],
            "kode_pos"                  => $row['kode_pos'],
            "telepon"                   => $row['telepon'],
            "hp"                        => $row['hp'],
            "email"                     => $row['email'],
            "tugas_tambahan"            => $row['tugas_tambahan'],
            "sk_cpns"                   => $row['sk_cpns'],
            "tanggal_cpns"              => $this->dateToTimeStamp($row['tanggal_cpns']),
            "sk_pengangkatan"           => $row['sk_pengangkatan'],
            "tmt_pengangkatan"          => $this->dateToTimeStamp($row['tmt_pengangkatan']),
            "lembaga_pengangkatan"      => $row['lembaga_pengangkatan'],
            "pangkat_id"                => $row['pangkat_id'],
            "sumber_gaji"               => $row['sumber_gaji'],
            "nama_ibu_kandung"          => $row['nama_ibu_kandung'],
            "status_perkawinan"         => $row['status_perkawinan'],
            "nama_suami_istri"          => $row['nama_suami_istri'],
            "nip_suami_istri"           => $row['nip_suami_istri'],
            "pekerjaan_suami_istri"     => $row['pekerjaan_suami_istri'],
            "tmt_pns"                   => $this->dateToTimeStamp($row['tmt_pns']),
            "lisensi_kepala_sekolah"    => $row['lisensi_kepala_sekolah'],
            "diklat_kepengawasan"       => $row['diklat_kepengawasan'],
            "keahlian_braille"          => $row['keahlian_braille'],
            "keahlian_bahasa_isyarat"   => $row["keahlian_bahasa_isyarat"],
            "npwp"                      => $row["npwp"],
            "nama_wajib_pajak"          => $row["nama_wajib_pajak"],
            "kewarganegaraan_id"        => $row["kewarganegaraan_id"],
            "bank"                      => $row["bank"],
            "nomor_rekening"            => $row["nomor_rekening"],
            "rekening_atas_nama"        => $row["rekening_atas_nama"],
            "nik"                       => $row["nik"],
            "no_kk"                     => $row["no_kk"],
            "karpeg"                    => $row["karpeg"],
            "karis_karsu"               => $row["karis_karsu"],
            "lintang"                   => $row["lintang"],
            "bujur"                     => $row["bujur"],
            "nuks"                      => $row["nuks"],
            "induk"                     => $row['induk'],
        ]);

        $this->data->push($staff);

        return $staff;
    }

    public function dateToTimeStamp($value, $format = "Y-m-d")
    {
        $date = date_create($value);

        return date_format($date, $format);
    }
}
