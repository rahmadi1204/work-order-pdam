<?php

namespace App\Imports;

use App\Models\Data\Staff;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StaffImport implements ToCollection, WithHeadingRow, WithChunkReading, WithBatchInserts
{

    public function transformDate($value, $format = 'Y-m-d')
    {
        try {
            return \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value))->format($format);
        } catch (\ErrorException$e) {
            return \Carbon\Carbon::createFromFormat($format, $value);
        }
    }
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            if ($row['nama'] != null) {
                Staff::updateOrCreate([
                    'kode_jabatan' => $row['uuid'],
                ], [
                    'nama' => $row['nama'],
                    'nip' => $row['nip'] ?? null,
                    'ruang' => $row['ruang'] ?? null,
                    'golongan' => $row['golongan'] ?? null,
                    'jenjang' => $row['jenjang'] ?? null,
                    'kategori_jabatan' => $row['kategori_jabatan'],
                    'jabatan' => $row['jabatan'] ?? null,
                    'status' => $row['status_jabatan'] ?? null,
                ]);
            }
        }
    }
    public function batchSize(): int
    {
        return 1000;
    }
    public function chunkSize(): int
    {
        return 1000;
    }
}
