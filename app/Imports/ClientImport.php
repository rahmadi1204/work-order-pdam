<?php

namespace App\Imports;

use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ClientImport implements ToCollection, WithHeadingRow, WithChunkReading, WithBatchInserts
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
            DB::table('clients')->upsert([
                'uuid' => $row['uuid'] ?? IdGenerator::generate(['table' => 'clients', 'field' => 'uuid', 'length' => 12, 'prefix' => 'CLN-', 'reset_on_prefix_change' => true]),
                'tgl_masuk' => $this->transformDate($row['tglmasuk']) ?? now(),
                'nama' => $row['nama'] ?? null,
                'no_sambungan' => $row['nosambungan'],
                'id_pelanggan' => $row['idpelanggan'] ?? date('YmdHis'),
                'no_telpon' => $row['telp'] ?? null,
                'no_hp' => $row['hp'] ?? null,
                'no_urut' => $row['nourut'] ?? null,
                'alamat' => $row['alamat'] ?? null,
                'id_area' => $row['idwilayah'] ?? null,
                'id_wilayah' => $row['idkelurahan'] ?? null,
                'id_jalan' => $row['idjalan'] ?? null,
                'is_active' => $row['aktif'] ?? null,
                'latitude' => $row['LongCoordinate'] ?? null,
                'longitude' => $row['LongCoordinate'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
                ['no_sambungan'],
                ['tgl_masuk', 'id_pelanggan', 'no_telpon', 'no_hp', 'no_urut', 'alamat', 'id_wilayah', 'is_active', 'latitude', 'longitude']);
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
