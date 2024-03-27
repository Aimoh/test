<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\Request;


class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * @OA\Get(
     *        path="/api/categories",
     *        summary="Список",
     *        tags={"Category"},
     *
     *        @OA\Response(
     *            response=200,
     *            description="Ok",
     *            @OA\JsonContent(
     *                @OA\Property(property="data", type="array", @OA\Items(
     *                    @OA\Property(property="id", type="integer", example=1),
     *                    @OA\Property(property="title", type="string", example="Фен для волос"),
     *                    @OA\Property(property="slug", type="string", example="fen-dlya-volos"),
     *                    @OA\Property(property="external_id", type="integer", example=3241),
     *                )),
     *            ),
     *        ),
     *    ),
     */
    public function index()
    {
        $categories = Category::all();

        return CategoryResource::collection($categories);
    }



    /**
     * @OA\Post(
     *        path="/api/categories",
     *        summary="Создание",
     *        tags={"Category"},
     *
     *        @OA\RequestBody(
     *            @OA\JsonContent(
     *                allOf={
     *                    @OA\Schema(
     *                        @OA\Property(property="title", type="string", example="Фен для волос"),
     *                        @OA\Property(property="slug", type="string", example="fen-dlya-volos"),
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
     *                    @OA\Property(property="external_id", type="integer", example=3241),
     *                ),
     *            ),
     *        ),
     *    ),
     */
    public function store(CategoryRequest $request)
    {
        $data = $request->validated();

        $category = $this->categoryService->store($data);

        return new CategoryResource($category);
    }



    /**
     * @OA\Get(
     *        path="/api/categories/{slug}",
     *        summary="Единичная запись",
     *        tags={"Category"},
     *        @OA\Parameter(
     *            description="Slug Категории",
     *            in="path",
     *            name="slug",
     *            required=true,
     *            example="fen-dlya-volos"
     *        ),
     *        @OA\Response(
     *            response=200,
     *            description="Ok",
     *        ),
     *    ),
     */
    public function show(string $slug)
    {
        $category = Category::query()->where('slug', $slug)->first();

        return CategoryResource::make($category);
    }



    /**
     * @OA\Put(
     *         path="/api/categories/{slug}",
     *         summary="Обновление",
     *         tags={"Category"},
     *         @OA\Parameter(
     *             description="Slug Категории",
     *             in="path",
     *             name="slug",
     *             required=true,
     *             @OA\Schema(type="string"),
     *             @OA\Examples(example="string", value="1", summary="An int value."),
     *         ),
     *         @OA\RequestBody(
     *             @OA\JsonContent(
     *                 allOf={
     *                     @OA\Schema(
     *                         @OA\Property(property="title", type="string", example="Фен для волос изменить"),
     *                         @OA\Property(property="external_id", type="integer", example=3241),
     *                     )
     *                 }
     *             )
     *         ),
     *
     *         @OA\Response(
     *             response=200,
     *             description="Ok",
     *             @OA\JsonContent(
     *                 @OA\Property(property="data", type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="title", type="string", example="Фен для волос"),
     *                     @OA\Property(property="slug", type="string", example="fen-dlya-volos"),
     *                     @OA\Property(property="external_id", type="integer", example=3241),
     *                 ),
     *             ),
     *         ),
     *     ),
     */
    public function update(string $slug, Request $request)
    {
        $category = Category::query()->where('slug', $slug)->firstOrFail();

        $category->update($request->all());

        return CategoryResource::make($category);
    }



    /**
     * @OA\Delete(
     *     path="/api/categories/{slug}",
     *     summary="Удаление",
     *     tags={"Category"},
     *     @OA\Parameter(
     *         description="Slug Категории",
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
        $result = $this->categoryService->destroy($slug);

        if (!$result) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        return response()->json(['message' => 'done'], 200);
    }


}
