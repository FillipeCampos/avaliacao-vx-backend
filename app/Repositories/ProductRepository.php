<?php


namespace App\Repositories;


use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductRepository
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getProducts(Request $request): JsonResponse
    {
        $products = Product::all();

        if(isset($request->product_name)) {
            $query = strtoupper($request->product_name);
            $products = Product::where('name','LIKE','%'.$query.'%')
                ->orWhere('reference','LIKE','%'.$query.'%')->get();
        }

        return response()->json([
            'success' => true,
            'products' =>  $products
        ]);
    }

    public function storeProducts(Request $request): JsonResponse
    {
        try {
            $product = new Product;
            $product->create($request->all());

            return response()->json([
                'message' => 'Produto cadastrado com sucesso!'
            ]);

        } catch(\Throwable $t) {
            return response()->json([
                'success' => false,
                'error_message' =>  $t->getMessage()
            ]);
        }
    }

    public function showProduct($id): JsonResponse
    {
        return response()->json([
            'Product' => Product::find($id)
        ]);
       // return Product::find($id);
    }

    public function updateProduct(Request $request, $id): JsonResponse
    {
        try {
            $product = Product::find($id);
            $product->name = $request->name;
            $product->reference = $request->reference;
            $product->price = $request->price;
            $product->delivery_days = $request->delivery_days;
            $product->save();

            return response()->json([
                'success' => true,
                'message' =>  'Produto atualizado com sucesso!'
            ]);

        } catch(\Throwable $t) {
            return response()->json([
                'success' => false,
                'error_message' =>  $t->getMessage()
            ]);
        }

    }

    public function destroyProduct($id): JsonResponse
    {
        try {
            $product = Product::find($id);
            $product->delete();

            return response()->json([
                'success' => true,
                'message' =>  'Produto excluído com sucesso!'
            ]);

        } catch(\Throwable $t) {
            return response()->json([
                'success' => false,
                'error_message' =>  $t->getMessage()
            ]);
        }
    }

}