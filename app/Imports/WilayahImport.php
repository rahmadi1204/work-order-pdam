<?php

namespace App\Imports;

use App\Models\Data\Area;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class WilayahImport implements ToCollection, WithHeadingRow, WithChunkReading, WithBatchInserts
{

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            // DB::table('areas')->upsert([
            //     'uuid' => $row['kode_jalan'],
            //     'kode_area' => $row['kode_area'],
            //     'nama_area' => $row['nama_area'],
            //     'kode_kelurahan' => $row['kode_kelurahan'],
            //     'nama_kelurahan' => $row['nama_kelurahan'],
            //     'kode_jalan' => $row['kode_jalan'],
            //     'nama_jalan' => $row['nama_jalan'],
            //     'deskripsi' => $row['deskripsi'] ?? '',
            //     'created_at' => $row['created_at'],
            //     'updated_at' => $row['updated_at'],
            // ], ['uuid'], ['nama_area', 'kode_kelurahan', 'nama_kelurahan', 'kode_jalan', 'nama_jalan', 'deskripsi', 'created_at', 'updated_at']);
            Area::updateOrCreate([
                'uuid' => 'AREA-' . $row['kode_jalan'],
            ], [
                'kode_area' => $row['kode_area'],
                'nama_area' => $row['nama_area'],
                'kode_wilayah' => $row['kode_wilayah'],
                // 'kode_kelurahan' => $row['kode_kelurahan'] ?? null,
                // 'nama_kelurahan' => $row['nama_kelurahan'] ?? null,
                'kode_jalan' => $row['kode_jalan'],
                'nama_jalan' => $row['nama_jalan'],
                'deskripsi' => $row['deskripsi'] ?? 'KOTA MADIUN',
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
