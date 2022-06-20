<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;

class Products implements FromCollection, WithHeadings, WithMapping, WithEvents, ShouldAutoSize
{

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Product::all();
    }

    public function headings(): array
    {
        return [
            'Item code',
            'Product number',
            'Product name',
            'Unit',
            'Quantity',
            'Price AED',
        ];
    }

    public function map ($signup):array {
        return [
            $signup->item_code,
            $signup->product_number,
            $signup->product_name,
            $signup->unit,
            $signup->quantity,
            $signup->price_aed,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getStyle('A1:I1')->applyFromArray([
                    'font' => [
                        'bold' => true
                    ],
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            'color' => ['argb' => 'FFF0000'],
                        ],
                    ]
                ]);
            }
        ];
    }
}
