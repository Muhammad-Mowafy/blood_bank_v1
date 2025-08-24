<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreCategoryRequest;
use App\Http\Requests\Api\UpdateCategoryRequest;
use App\Models\Category;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use ApiResponse;

    // Get All Categories for DropDown
    public function index()
    {
        $categories = Category::all();
        return $this->apiDataResponse(
            ['categories' => $categories],
            'Categories fetched successfully'
        );
    }

    // Store Category
//    public function store(StoreCategoryRequest $request)
//    {
//        $category = Category::create($request->validated());
//
//        return $this->apiDataResponse(
//            ['category' => $category],
//            'Category created successfully'
//        );
//    }
//
//    //  Show Category
//    public function show($id)
//    {
//        $category = Category::find($id);
//
//        if (!$category) {
//            return $this->apiErrorResponse('Category not found', 404);
//        };
//
//        return $this->apiDataResponse(
//            ['category' => $category],
//            'Category fetched successfully'
//        );
//    }
//
//    public function update(UpdateCategoryRequest $request, $id)
//    {
//        $category = Category::find($id);
//
//        if (!$category) {
//            return $this->apiErrorResponse('Category not found', 404);
//        };
//
//        $category->update($request->validated());
//
//        return $this->apiDataResponse(
//            ['category' => $category],
//            'Category updated successfully'
//        );
//    }
//
//    public  function destroy($id) {
//        $category = Category::find($id);
//
//        if (!$category) {
//            return $this->apiErrorResponse('Category not found', 404);
//        };
//
//        $category->delete();
//
//        return $this->apiDataResponse(
//            ['category' => $category],
//            'Category deleted successfully'
//        );
//    }
}

