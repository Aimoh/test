<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{

    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * @OA\Get(
     *       path="/api/products",
     *       summary="Список",
     *       tags={"Product"},
     *
     *       @OA\Response(
     *           response=200,
     *           description="Ok",
     *           @OA\JsonContent(
     *               @OA\Property(property="data", type="array", @OA\Items(
     *                   @OA\Property(property="id", type="integer", example=1),
     *                   @OA\Property(property="title", type="string", example="Фен для волос"),
     *                   @OA\Property(property="slug", type="string", example="fen-dlya-volos"),
     *                   @OA\Property(property="price", type="float", example=937.4),
     *                   @OA\Property(property="external_id", type="integer", example=3241),
     *               )),
     *           ),
     *       ),
     *   ),
     */

    public function index()
    {
        $products = Product::all();

        return ProductResource::collection($products);
    }


    /**
     * @OA\Post(
     *       path="/api/products",
     *       summary="Создание",
     *       tags={"Product"},
     *
     *       @OA\RequestBody(
     *           @OA\JsonContent(
     *               allOf={
     *                   @OA\Schema(
     *                       @OA\Property(property="title", type="string", example="Фен для волос"),
     *                       @OA\Property(property="slug", type="string", example="fen-dlya-volos"),
     *                       @OA\Property(property="price", type="float", example=937.4),
     *                       @OA\Property(property="external_id", type="integer", example=3241),
     *                   )
     *               }
     *           )
     *       ),
     *
     *       @OA\Response(
     *           response=200,
     *           description="Ok",
     *           @OA\JsonContent(
     *               @OA\Property(property="data", type="object",
     *                   @OA\Property(property="id", type="integer", example=1),
     *                   @OA\Property(property="title", type="string", example="Фен для волос"),
     *                   @OA\Property(property="slug", type="string", example="fen-dlya-volos"),
     *                   @OA\Property(property="price", type="float", example=937.4),
     *                   @OA\Property(property="external_id", type="integer", example=3241),
     *               ),
     *           ),
     *       ),
     *   ),
     */
    public function store(ProductRequest $request)
    {
        $data = $request->validated();

        $product = $this->productService->store($data);

        return new ProductResource($product);
    }


    /**
     * @OA\Get(
     *       path="/api/products/{slug}",
     *       summary="Единичная запись",
     *       tags={"Product"},
     *       @OA\Parameter(
     *           description="Slug продукта",
     *           in="path",
     *           name="slug",
     *           required=true,
     *           example="fen-dlya-volos"
     *       ),
     *       @OA\Response(
     *           response=200,
     *           description="Ok",
     *       ),
     *   ),
     */
    public function show(string $slug)
    {
        $product = Product::query()
            ->where('slug', $slug)
            ->first();

        return ProductResource::make($product);
    }


    /**
     * @OA\Put(
     *        path="/api/products/{slug}",
     *        summary="Обновление",
     *        tags={"Product"},
     *        @OA\Parameter(
     *            description="Slug продукта",
     *            in="path",
     *            name="slug",
     *            required=true,
     *            @OA\Schema(type="string"),
     *            @OA\Examples(example="string", value="1", summary="An int value."),
     *        ),
     *        @OA\RequestBody(
     *            @OA\JsonContent(
     *                allOf={
     *                    @OA\Schema(
     *                        @OA\Property(property="title", type="string", example="Фен для волос изменить"),
     *                        @OA\Property(property="price", type="float", example=1937.5),
     *                        @OA\Property(property="external_id", type="integer", example=3241),
     *                    )
     *                }
     *            )
     *        ),
     *
     *        @OA\Response(
     *            response=200,
     *            description="Ok",
     *            @OA\JsonContent(
     *                @OA\Property(property="data", type="object",
     *                    @OA\Property(property="id", type="integer", example=1),
     *                    @OA\Property(property="title", type="string", example="Фен для волос"),
     *                    @OA\Property(property="slug", type="string", example="fen-dlya-volos"),
     *                    @OA\Property(property="price", type="float", example=937.4),
     *                    @OA\Property(property="external_id", type="integer", example=3241),
     *                ),
     *            ),
     *        ),
     *    ),
     */
    public function update(string $slug, Request $request)
    {
        $product = Product::query()
            ->where('slug', $slug)
            ->firstOrFail();

        $product->update($request->all());

        return ProductResource::make($product);
    }

    /**
     * @OA\Delete(
     *     path="/api/products/{slug}",
     *     summary="Удаление",
     *     tags={"Product"},
     *     @OA\Parameter(
     *         description="Slug Продукта",
     *         in="path",
     *         name="slug",
     *         required=true,
     *         example="fen-dlya-volos"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Ok",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="done"),
     *         ),
     *     ),
     * ),
     */
    public function destroy(string $slug)
    {
        $result = $this->productService->destroy($slug);

        if (!$result) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        return response()->json(['message' => 'done'], 200);
    }


    /**
     * @OA\Get(
     *        path="/api/popular-products",
     *        summary="Список популярных товаров",
     *        tags={"Product"},
     *
     *        @OA\Response(
     *            response=200,
     *            description="Get the 10 popular products where the name contains 'A'",
     *            @OA\JsonContent(
     *                @OA\Property(property="data", type="array", @OA\Items(
     *                    @OA\Property(property="id", type="integer", example=1),
     *                    @OA\Property(property="title", type="string", example="Фен для волос"),
     *                    @OA\Property(property="slug", type="string", example="fen-dlya-volos"),
     *                    @OA\Property(property="price", type="float", example=937.4),
     *                    @OA\Property(property="external_id", type="integer", example=3241),
     *                )),
     *            ),
     *        ),
     *    ),
     */

    public function popularProducts(Request $request)
    {
        $popularProducts = Cache::get('popularProducts');

        if (!$popularProducts) {
            $popularProducts = Product::where('title', 'like', '%A%')
                ->take(10)->get();


            Cache::put('popularProducts', $popularProducts, 3600);
        }
        return response()->json($popularProducts);
    }
}
