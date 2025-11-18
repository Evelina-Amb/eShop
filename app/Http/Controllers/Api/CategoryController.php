<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use App\Http\Resources\CategoryResource;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends BaseController
{
    public function index()
    {
        return $this->sendResponse(
            CategoryResource::collection(Category::all()),
            'Kategorijos sėkmingai gautos.'
        );
    }

    public function show($id)
    {
        $item = Category::find($id);
        if (!$item) return $this->sendError('Kategorija nerasta', 404);

        return $this->sendResponse(new CategoryResource($item), 'Kategorija rasta.');
    }

    public function store(StoreCategoryRequest $request)
    {
        $item = Category::create($request->validated());
        return $this->sendResponse(new CategoryResource($item), 'Kategorija sukurta sėkmingai.', 201);
    }

    public function update(UpdateCategoryRequest $request, $id)
    {
        $item = Category::find($id);
        if (!$item) return $this->sendError('Kategorija nerasta', 404);

        $item->update($request->validated());
        return $this->sendResponse(new CategoryResource($item), 'Kategorija atnaujinta.');
    }

    public function destroy($id)
    {
        $item = Category::find($id);
        if (!$item) return $this->sendError('Kategorija nerasta', 404);

        $item->delete();
        return $this->sendResponse(null, 'Kategorija ištrinta.');
    }
}
