<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            return (new ProductRepository())->getProducts($request);
        } catch(\Throwable $t) {
            return response()->json([
                'success' => false,
                'error_message' =>  $t->getMessage()
            ]);
        }
    }
    /**
     * @param Request $request
     * @return JsonResponse
     */

    public function store(Request $request): JsonResponse
    {
        return (new ProductRepository())->storeProducts($request);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            return (new ProductRepository())->showProduct($id);
        } catch(\Throwable $t) {
            return response()->json([
                'success' => false,
                'error_message' =>  'Produto não encontrado!'
            ]);
        }
    }

    /**
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        try {
            return (new ProductRepository())->updateProduct($request, $id);
        } catch(\Throwable $t) {
            return response()->json([
                'success' => false,
                'error_message' =>  $t->getMessage()
            ]);
        }
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        return (new ProductRepository())->destroyProduct($id);
    }
}
