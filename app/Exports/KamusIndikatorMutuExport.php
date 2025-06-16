<?php

namespace App\Exports;

use App\Models\KamusIndikatorMutu;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class KamusIndikatorMutuExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithEvents
{
    public function collection()
    {
        return KamusIndikatorMutu::with([
            'indicator',
            'dimensiMutu',
            'metodologiPengumpulan',
            'cakupanData',
            'frekuensiPengumpulan',
            'frekuensiAnalisa',
            'metodologiAnalisa',
            'interpretasiData',
            'publikasiData'
        ])->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Indikator',
            'Definisi Operasional',
            'Tujuan',
            'Dimensi Mutu',
            'Dasar Pemikiran',
            'Formula Pengukuran',
            'Metodologi Pengumpulan Data',
            'Jenis Metodologi',
            'Cakupan Data',
            'Pengumpulan Data',
            'Frekuensi Pengumpulan',
            'Frekuensi Analisa',
            'Metodologi Analisa',
            'Interpretasi Data',
            'Sumber Data',
            'Penanggung Jawab'
        ];
    }

    public function map($row): array
    {
        static $number = 0;
        $number++;
        
        return [
            $number,
            $row->indicator->name ?? '-',
            $row->definisi_operasional,
            $row->tujuan,
            $row->dimensiMutu->nama ?? '-',
            $row->dasar_pemikiran,
            $row->formula_pengukuran,
            $row->metodologi_pengumpulan_data,
            $row->metodologiPengumpulan->nama ?? '-',
            $row->cakupanData->nama ?? '-',
            $row->pengumpulan_data,
            $row->frekuensiPengumpulan->nama ?? '-',
            $row->frekuensiAnalisa->nama ?? '-',
            $row->metodologiAnalisa->nama ?? '-',
            $row->interpretasiData->nama ?? '-',
            $row->sumber_data,
            $row->penanggung_jawab_pengumpul_data
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'E2E8F0']
                ]
            ]
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getStyle('A1:Q1')->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                ]);

                // Auto-filter
                $event->sheet->setAutoFilter($event->sheet->calculateWorksheetDimension());
            },
        ];
    }
} 