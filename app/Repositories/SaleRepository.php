<?php


namespace App\Repositories;


use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SaleRepository
{
    public function getAllSales(Request $request): LengthAwarePaginator
    {
        $per_page = 20;
        if(isset($request->per_page)) {
            $per_page = $request->per_page;
        }

        return Sale::with('products:name,delivery_days')->paginate($per_page);
    }

    public function storeSale($dataSales): JsonResponse
    {
        $sale = new Sale;
        $sale->purchase_at = Carbon::parse($dataSales['purchase_at']);
        $sale->amount = $dataSales['amount'];
        $sale->delivery_days = $dataSales['delivery_days'];
        $sale->save();
        $sale->products()->sync($dataSales['products']);
        return Response()->json(['message'=>'Venda Concluida com sucesso!'], 201);
    }

    public function showSale($id)
    {
        return Sale::with('products:name,delivery_days')->find($id);
    }

    public function updateSale(Request $request, $id): JsonResponse
    {
        try {
            $sale = Sale::find($id);
            $sale->purchase_at = Carbon::parse($request->purchase_at);
            $sale->save();

            $sale->products()->sync($request->products);

            return Response()->json('Venda Alterada com sucesso!', 200);
        } catch(\Throwable $t) {
            return response()->json([
                'success' => false,
                'error_message' =>  'Erro ao atualizar venda!'
            ]);
        }
    }

    public function destroySale($id): JsonResponse
    {
        try {
            $sale = Sale::find($id);
            $sale->products()->detach();
            $sale->delete();
            return Response()->json('Venda Excluida com sucesso!', 200);
        } catch(\Throwable $t) {
            return response()->json([
                'success' => false,
                'error_message' =>  'Erro ao excluir venda!'
            ]);
        }
    }

}