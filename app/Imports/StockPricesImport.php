<?php

namespace App\Imports;

use App\Models\StockPrice;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StockPricesImport implements ToModel, WithChunkReading, ShouldQueue,WithHeadingRow
{
    public function model(array $row)
    {
        return new StockPrice([
            'stock' => $row['stock'],
            'price' => (float) $row['price'],
            'date'  => Carbon::parse($row['date']),
        ]);
    }

    public function chunkSize(): int
    {
        return 1000; // process 1000 rows per job
    }
}

