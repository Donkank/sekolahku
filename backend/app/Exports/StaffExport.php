<?php

namespace App\Exports;

use App\Models\Staff;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\DefaultValueBinder;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class StaffExport extends DefaultValueBinder implements FromCollection, WithHeadings, ShouldAutoSize, WithColumnFormatting, WithCustomValueBinder
{
    public function collection()
    {
        return Staff::all();
    }

    public function headings(): array
    {
        return [
            '#', "nama", "nuptk", "jk", "tempat_lahir", "tanggal_lahir", "nip", "status_kepegawaian", "jenis_ptk", "agama", "alamat_jalan", "rt", "rw", "nama_dusun", "nama_desa_kelurahan", "kecamatan", "kode_pos", "telepon", "hp", "email", "tugas_tambahan", "sk_cpns", "tanggal_cpns", "sk_pengangkatan", "tmt_pengangkatan", "lembaga_pengangkatan", "pangkat_id", "sumber_gaji", "nama_ibu_kandung", "status_perkawinan", "nama_suami_istri", "nip_suami_istri", "pekerjaan_suami_istri", "tmt_pns", "lisensi_kepala_sekolah", "diklat_kepengawasan", "keahlian_braille", "keahlian_bahasa_isyarat", "npwp", "nama_wajib_pajak", "kewarganegaraan_id", "bank", "nomor_rekening", "rekening_atas_nama", "nik", "no_kk", "karpeg", "karis_karsu", "lintang", "bujur", "nuks", "induk", "deleted_at", "created_at", "updated_at"
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function (AfterSheet $event) {
                $cellRange = 'A1:BC1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(12);
            },
        ];
    }

    public function columnFormats(): array
    {
        return [
            'F' => NumberFormat::FORMAT_DATE_YYYYMMDD,
            'W' => NumberFormat::FORMAT_DATE_YYYYMMDD,
            'Y' => NumberFormat::FORMAT_DATE_YYYYMMDD,
            'AH' => NumberFormat::FORMAT_DATE_YYYYMMDD,
            'BA' => NumberFormat::FORMAT_DATE_YYYYMMDD,
            'BB' => NumberFormat::FORMAT_DATE_YYYYMMDD,
            'BC' => NumberFormat::FORMAT_DATE_YYYYMMDD,
        ];
    }

    public function bindValue(Cell $cell, $value)
    {
        if (is_numeric($value)) {
            $cell->setValueExplicit($value, DataType::TYPE_STRING2);

            return true;
        }

        // Duct tape, sadly, @see https://github.com/SpartnerNL/Laravel-Excel/blob/3.1/src/DefaultValueBinder.php
        $defaultValueBinder = new DefaultValueBinder();

        // else return default behavior
        return $defaultValueBinder->bindValue($cell, $value);
    }
}
