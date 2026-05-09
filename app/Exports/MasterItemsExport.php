<?php

namespace App\Exports;

use App\Models\MasterItem;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MasterItemsExport implements FromCollection, WithHeadings, WithMapping
{
    private $rowNumber = 0;

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return MasterItem::with('categories')->get();
    }

    /**
    * @return array
    */
    public function headings(): array
    {
        return [
            'No',
            'Nama kategori',
            'Nama Items',
            'Nama supplier',
            'Harga',
            'Laba (%)',
            'Harga jual',
        ];
    }

    /**
    * @param mixed $item
    * @return array
    */
    public function map($item): array
    {
        $this->rowNumber++;
        
        $categories = $item->categories->pluck('nama')->implode(', ');

        return [
            $this->rowNumber,
            $categories ?: '-',
            $item->nama,
            $item->supplier,
            $item->harga_beli,
            $item->laba,
            $item->harga_jual,
        ];
    }
}
