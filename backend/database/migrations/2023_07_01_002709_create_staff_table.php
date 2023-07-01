<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama');
            $table->string('nuptk')->nullable();
            $table->enum('jk', ['L', 'P']);
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('nip')->nullable();
            $table->string('status_kepegawaian');
            $table->string('jenis_ptk');
            $table->enum('agama', ['Islam', 'Kristen', 'Katholik', 'Hindu', 'Budha', 'Khonghucu', 'Kepercayaan kpd Tuhan YME', 'Lainnya']);
            $table->string('alamat_jalan')->nullable();
            $table->integer('rt')->nullable();
            $table->integer('rw')->nullable();
            $table->string('nama_dusun')->nullable();
            $table->string('nama_desa_kelurahan');
            $table->string('kecamatan');
            $table->integer('kode_pos')->nullable();
            $table->string('telepon')->nullable();
            $table->string('hp')->nullable();
            $table->string('email');
            $table->string('tugas_tambahan')->nullable();
            $table->string('sk_cpns')->nullable();
            $table->date('tanggal_cpns')->nullable();
            $table->string('sk_pengangkatan');
            $table->date('tmt_pengangkatan')->nullable();
            $table->string('lembaga_pengangkatan')->nullable();
            $table->string('pangkat_id')->nullable();
            $table->enum('sumber_gaji', ['APBN', 'APBD Provinsi', 'APBD Kabupaten/Kota', 'Yayasan', 'Sekolah', 'Lembaga Donor', ' Lainnya']);
            $table->string('nama_ibu_kandung');
            $table->string('status_perkawinan');
            $table->string('nama_suami_istri')->nullable();
            $table->string('nip_suami_istri')->nullable();
            $table->enum('pekerjaan_suami_istri', ['Tidak bekerja', 'Nelayan', 'Petani', 'Peternak', 'PNS/TNI/Polri', 'Karyawan Swasta', 'Pedagang Kecil', 'Pedagang Besar', 'Wiraswasta', 'Wirausaha', 'Buruh', 'Pensiunan', 'Tenaga Kerja Indonesia', 'Karyawan BUMN', 'Tidak dapat diterapkan', 'Sudah Meninggal', 'Lainnya']);
            $table->date('tmt_pns')->nullable();
            $table->enum('lisensi_kepala_sekolah', ['Tidak', 'Ya']);
            $table->enum('diklat_kepengawasan', ['Tidak', 'Ya']);
            $table->enum('keahlian_braille', ['Tidak', 'Ya']);
            $table->enum('keahlian_bahasa_isyarat', ['Tidak', 'Ya']);
            $table->string('npwp')->nullable();
            $table->string('nama_wajib_pajak')->nullable();
            $table->string('kewarganegaraan_id')->default('ID');
            $table->string('bank')->nullable();
            $table->string('nomor_rekening')->nullable();
            $table->string('rekening_atas_nama')->nullable();
            $table->string('nik');
            $table->string('no_kk')->nullable();
            $table->string('karpeg')->nullable();
            $table->string('karis_karsu')->nullable();
            $table->string('lintang')->nullable();
            $table->string('bujur')->nullable();
            $table->string('nuks')->nullable();
            $table->enum('induk', ['Tidak', 'Ya']);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
