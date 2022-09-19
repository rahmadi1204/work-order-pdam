<?php

namespace App\Imports;

use App\Models\Data\Kelurahan;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class KelurahanImport implements ToCollection, WithHeadingRow, WithChunkReading, WithBatchInserts
{

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            if ($row['kode_kecamatan'] < 10) {
                $row['kode_kecamatan'] = '0' . $row['kode_kecamatan'];
            }
            if ($row['kode_kelurahan'] < 10) {
                $row['kode_kelurahan'] = '0' . $row['kode_kelurahan'];
            }
            Kelurahan::updateOrCreate([
                'uuid' => 'KEL-' . $row['kode_kecamatan'] . '.' . $row['kode_kelurahan'],
            ], [
                'kode_kecamatan' => $row['kode_kecamatan'],
                'nama_kecamatan' => $row['nama_kecamatan'],
                'kode_kelurahan' => $row['kode_kelurahan'],
                'nama_kelurahan' => $row['nama_kelurahan'],
            ]);
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
