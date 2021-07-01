<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalesRequest;
use App\Repositories\SaleRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Sale;

class SaleController extends Controller
{
    /**
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function index(Request $request): LengthAwarePaginator
    {
        return (new SaleRepository())->getAllSales($request);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JsonResponse
     */
    public function store(SalesRequest $request): JsonResponse
    {
        try {
            $dataSales = $request->only('purchase_at', 'delivery_days', 'amount', 'products');

            return (new SaleRepository())->storeSale($dataSales);

        } catch(\Throwable $t) {
            return response()->json([
                'success' => false,
                'error_message' =>  $t->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Sale|Sale[]|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|\Illuminate\Http\Response
     */
    public function show(int $id)
    {
        return (new SaleRepository())->showSale($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        return (new SaleRepository())->updateSale($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        return (new SaleRepository())->destroySale($id);
    }
}
