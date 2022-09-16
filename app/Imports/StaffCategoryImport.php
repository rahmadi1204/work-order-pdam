<?php

namespace App\Imports;

use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StaffCategoryImport implements ToCollection, WithHeadingRow, WithChunkReading, WithBatchInserts
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
                'uuid' => $row['uuid'] ?? IdGenerator::generate(['table' => 'staff_categories', 'field' => 'uuid', 'length' => 12, 'prefix' => 'SKT-', 'reset_on_prefix_change' => true]),
                'kategori' => $row['kategori'],
                'nama' => $row['nama'] ?? null,
                'deskripsi' => $row['deskripsi'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
                ['uuid'],
                ['kategori', 'nama', 'deskripsi']);
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
