<?php

namespace App\Imports;

use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
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
            DB::table('staff_categories')->upsert([
                'uuid' => $row['uuid'],
                'kategori' => $row['kategori'],
                'jabatan' => $row['jabatan'] ?? null,
                'status' => $row['status_jabatan'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
                ['uuid'],
                ['kategori', 'jabatan', 'status', 'updated_at']);
        }
        foreach ($collection as $row) {
            if ($row['nama'] != null) {
                DB::table('staff')->upsert([
                    'uuid' => IdGenerator::generate(['table' => 'staff', 'field' => 'uuid', 'length' => 12, 'prefix' => 'STF-', 'reset_on_prefix_change' => true]),
                    'category_id' => $row['uuid'],
                    'nama' => $row['nama'],
                    'nip' => $row['nip'] ?? null,
                    'ruang' => $row['ruang'] ?? null,
                    'golongan' => $row['golongan'] ?? null,
                    'jenjang' => $row['jenjang'] ?? null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                    ['uuid', 'category_id'],
                    ['nama', 'nip', 'ruang', 'golongan', 'jenjang']);
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
