<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithProperties;
use Maatwebsite\Excel\Concerns\WithStyles;

class StaffExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles, WithProperties
{
    public function __construct($staffs, $title)
    {
        $this->staffs = $staffs;
        $this->title = $title;
    }
    public function collection()
    {
        return $this->staffs;
    }
    public function title(): string
    {
        return $this->title;
    }
    public function headings(): array
    {
        return [
            'UUID',
            'Nama',
            'Kode Jabatan',
            'Kategori Jabatan',
            'Jabatan',
            'NIP',
            'Ruangan',
            'Golongan',
            'Jenjang',
            'Status Jabatan',
        ];
    }
    public function styles($sheet)
    {
        $sheet->getStyle('A1:J1')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
        ]);
    }
    public function properties(): array
    {
        return [
            'creator' => 'MUSTAJIB UMRONI',
            'lastModifiedBy' => 'Aplikasi Work Order PDAM Kota Madiun',
            'title' => $this->title,
            'description' => 'Data Pegawai',
            'subject' => 'Data Pegawai',
            'keywords' => 'Data Pegawai',
            'category' => 'Data Pegawai',
            'manager' => 'Aplikasi Work Order PDAM Kota Madiun',
            'company' => 'Aplikasi Work Order PDAM Kota Madiun',
        ];
    }
}
