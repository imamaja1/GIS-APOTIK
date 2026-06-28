<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateApotekRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'kecamatan_id'                  => ['required', 'exists:tb_kecamatan,id'],
            'nama_apotek'                   => ['required', 'string', 'max:150'],
            'jalan_apotek'                  => ['required', 'string', 'max:150'],
            'alamat_lengkap'                => ['required', 'string'],
            'no_telp'                       => ['nullable', 'string', 'max:20'],
            'latitude'                      => ['required', 'numeric', 'between:-90,90'],
            'longitude'                     => ['required', 'numeric', 'between:-180,180'],
            'jam_operasional'               => ['required', 'array', 'size:7'],
            'jam_operasional.*.status_buka' => ['required', 'in:Buka,Tutup'],
            'jam_operasional.*.jam_buka'    => ['nullable', 'required_if:jam_operasional.*.status_buka,Buka', 'date_format:H:i'],
            'jam_operasional.*.jam_tutup'   => ['nullable', 'required_if:jam_operasional.*.status_buka,Buka', 'date_format:H:i'],
        ];
    }

    public function messages(): array
    {
        return [
            'kecamatan_id.required'                  => 'Kecamatan wajib dipilih.',
            'kecamatan_id.exists'                    => 'Kecamatan tidak valid.',
            'nama_apotek.required'                   => 'Nama apotek wajib diisi.',
            'nama_apotek.max'                        => 'Nama apotek maksimal 150 karakter.',
            'jalan_apotek.required'                  => 'Nama jalan wajib diisi.',
            'jalan_apotek.max'                       => 'Nama jalan maksimal 150 karakter.',
            'alamat_lengkap.required'                => 'Alamat lengkap wajib diisi.',
            'no_telp.max'                            => 'Nomor telepon maksimal 20 karakter.',
            'latitude.required'                      => 'Latitude wajib diisi.',
            'latitude.numeric'                       => 'Latitude harus berupa angka.',
            'latitude.between'                       => 'Latitude antara -90 hingga 90.',
            'longitude.required'                     => 'Longitude wajib diisi.',
            'longitude.numeric'                      => 'Longitude harus berupa angka.',
            'longitude.between'                      => 'Longitude antara -180 hingga 180.',
            'jam_operasional.required'               => 'Jam operasional wajib diisi.',
            'jam_operasional.size'                   => 'Jam operasional harus 7 hari.',
            'jam_operasional.*.status_buka.required' => 'Status buka wajib diisi.',
            'jam_operasional.*.status_buka.in'       => 'Status buka harus Buka atau Tutup.',
            'jam_operasional.*.jam_buka.required_if' => 'Jam buka wajib diisi jika status Buka.',
            'jam_operasional.*.jam_buka.date_format' => 'Format jam buka HH:MM.',
            'jam_operasional.*.jam_tutup.required_if'=> 'Jam tutup wajib diisi jika status Buka.',
            'jam_operasional.*.jam_tutup.date_format'=> 'Format jam tutup HH:MM.',
        ];
    }
}
