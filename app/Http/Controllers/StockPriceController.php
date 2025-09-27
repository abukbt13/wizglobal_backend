<?php

namespace App\Http\Controllers;

use App\Imports\StockPricesImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class StockPriceController extends Controller
{
    public function upload(Request $request)
    {

        try {
            $validated = $request->validate([
                'file' => 'required|mimes:csv,xlsx,xls|max:20480',
            ]);

            Excel::import(new StockPricesImport, $request->file('file'));

            return response()->json([
                'status'  => 'success',
                'message' => 'File imported successfully',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Validation failed',
                'errors'  => $e->errors(),
            ], 422);
        } catch (\Throwable $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Import failed: ' . $e->getMessage(),
            ], 500);
        }
    }
    public function AnalyseStockPrices()
    {
        $results = \DB::table('stock_prices')
            ->select(
                'stock',
                \DB::raw('MAX(price) - MIN(price) as gain')
            )
            ->groupBy('stock')
            ->orderByDesc('gain') // sort by biggest gain first
            ->take(5) // fetch only top 5
            ->get();

        return response()->json($results);
    }



}
