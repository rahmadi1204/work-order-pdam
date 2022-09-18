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
            $row['id_kelurahan'] = $row['id_kelurahan'] ?? 0;
            if ($row['id_kecamatan'] < 10) {
                $row['id_kecamatan'] = '0' . $row['id_kecamatan'];
            }
            if ($row['id_kelurahan'] < 10) {
                $row['id_kelurahan'] = '0' . $row['id_kelurahan'];
            }
            if ($row['id_wilayah'] < 10) {
                $row['id_wilayah'] = '0' . $row['id_wilayah'];
            }
            if ($row['id_jalan'] < 10) {
                $row['id_jalan'] = '0' . $row['id_jalan'];
            }
            DB::table('clients')->upsert([
                'uuid' => $row['uuid'] ?? IdGenerator::generate(['table' => 'clients', 'field' => 'uuid', 'length' => 12, 'prefix' => 'CLN-', 'reset_on_prefix_change' => true]),
                'tgl_masuk' => $this->transformDate($row['tgl_masuk']) ?? now(),
                'nama' => $row['nama'] ?? null,
                'no_sambungan' => $row['no_sambungan'],
                'id_pelanggan' => '0' . substr($row['no_sambungan'], 0, 1) . '/' . substr($row['no_sambungan'], 1, 2) . '/' . substr($row['no_sambungan'], 3, 2) . '/' . substr($row['no_sambungan'], 5, 4),
                'no_telpon' => $row['telp'] ?? null,
                'no_hp' => $row['hp'] ?? null,
                'no_urut' => $row['no_urut'] ?? null,
                'alamat' => $row['alamat'] ?? null,
                'id_area' => 'AREA-' . $row['id_kecamatan'] . '.' . $row['id_wilayah'] . '.' . $row['id_jalan'] ?? null,
                'id_kecamatan' => $row['id_kecamatan'] ?? null,
                'id_kelurahan' => $row['id_kecamatan'] . '.' . $row['id_kelurahan'] ?? null,
                'id_wilayah' => $row['id_kecamatan'] . '.' . $row['id_wilayah'] ?? null,
                'id_jalan' => $row['id_kecamatan'] . '.' . $row['id_wilayah'] . '.' . $row['id_jalan'] ?? null,
                'is_active' => $row['aktif'] ?? 0,
                'latitude' => $row['LongCoordinate'] ?? null,
                'longitude' => $row['LongCoordinate'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
                ['no_sambungan'],
                ['tgl_masuk', 'nama', 'no_telpon', 'no_hp', 'no_urut', 'alamat', 'id_area', 'id_kecamatan', 'id_kelurahan', 'id_wilayah', 'id_jalan', 'is_active', 'latitude', 'longitude', 'updated_at']
            );
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
