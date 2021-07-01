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

    public function storeSale(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(),[
                'purchase_at' => 'required|date|before:tomorrow',
                'delivery_days' => 'required',
                'amount' => 'required',
                'products'=>'required'
            ]);

            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()], 422);
            }

            $sale = new Sale;
            $sale->purchase_at = Carbon::parse($request->purchase_at);
            $sale->amount = $request->amount;
            $sale->delivery_days = $request->delivery_days;
            $sale->save();
            $sale->products()->sync($request->products);
            return Response()->json(['message'=>'Venda Concluida com sucesso!'], 201);

        } catch(\Throwable $t) {
            return response()->json([
                'success' => false,
                'error_message' =>  $t->getMessage()
            ]);
        }
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