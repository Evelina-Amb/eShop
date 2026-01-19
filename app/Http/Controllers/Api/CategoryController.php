<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\BaseCollection;
use App\Services\CategoryService;

class CategoryController extends BaseController
{
    protected CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }
/**
 * @OA\Get(
 *   path="/api/category",
 *   summary="Get all categories",
 *   tags={"Category"},
 *   @OA\Response(
 *     response=200,
 *     description="Categories retrieved"
 *   )
 * )
 */
    public function index()
    {
        $categories = $this->categoryService->getAll();
        return $this->sendResponse(new BaseCollection($categories,  CategoryResource::class), 'Categories retrieved.');
    }
/**
 * @OA\Get(
 *   path="/api/category/{id}",
 *   summary="Get single category",
 *   tags={"Category"},
 *   @OA\Parameter(
 *     name="id",
 *     in="path",
 *     required=true,
 *     @OA\Schema(type="integer")
 *   ),
 *   @OA\Response(response=200, description="Category found"),
 *   @OA\Response(response=404, description="Category not found")
 * )
 */
    public function show($id)
    {
        $category = $this->categoryService->getById($id);
        if (!$category) return $this->sendError('Category not found.', 404);

        return $this->sendResponse(new CategoryResource($category), 'Category found.');
    }
/**
 * @OA\Post(
 *   path="/api/category",
 *   summary="Create category",
 *   tags={"Category"},
 *   @OA\RequestBody(
 *     required=true,
 *     @OA\JsonContent(
 *       @OA\Property(property="pavadinimas", type="string"),
 *       @OA\Property(property="tipo_zenklas", type="string")
 *     )
 *   ),
 *   @OA\Response(response=201, description="Category created"),
 *   @OA\Response(response=400, description="Validation error")
 * )
 */
    public function store(StoreCategoryRequest $request)
    {
        $category = $this->categoryService->create($request->validated());
        return $this->sendResponse(new CategoryResource($category), 'Category created.', 201);
    }

/**
 * @OA\Put(
 *   path="/api/category/{id}",
 *   summary="Update category",
 *   tags={"Category"},
 *   @OA\Parameter(
 *     name="id",
 *     in="path",
 *     required=true,
 *     @OA\Schema(type="integer")
 *   ),
 *   @OA\RequestBody(
 *     required=true,
 *     @OA\JsonContent(
 *       @OA\Property(property="pavadinimas", type="string"),
 *       @OA\Property(property="tipo_zenklas", type="string")
 *     )
 *   ),
 *   @OA\Response(response=200, description="Category updated"),
 *   @OA\Response(response=404, description="Category not found")
 * )
 */
    public function update(UpdateCategoryRequest $request, $id)
    {
        $category = $this->categoryService->update($id, $request->validated());
        if (!$category) return $this->sendError('Category not found.', 404);

    return $this->sendResponse(new CategoryResource($category), 'Category updated.');
    }
/**
 * @OA\Delete(
 *   path="/api/category/{id}",
 *   summary="Delete category",
 *   tags={"Category"},
 *   @OA\Parameter(
 *     name="id",
 *     in="path",
 *     required=true,
 *     @OA\Schema(type="integer")
 *   ),
 *   @OA\Response(response=200, description="Category deleted"),
 *   @OA\Response(response=404, description="Category not found")
 * )
 */
    public function destroy($id)
    {
        $deleted = $this->categoryService->delete($id);
        if (!$deleted) return $this->sendError('Category not found.', 404);

        return $this->sendResponse(null, 'Category deleted.');
    }
}
