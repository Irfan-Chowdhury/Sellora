<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CategoryStoreRequest;
use App\Http\Requests\Category\CategoryUpdateRequest;
use Illuminate\Http\Request;
use App\Services\CategoryService;
use Exception;
use Str;
use Image;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{

    private $categoryService;
    public function __construct(CategoryService $categoryService){
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        $categories =  $this->categoryService->getAllCategories();

        return view('admin.pages.category.index', compact('categories'));
    }

    public function dataTable(){
        return $this->categoryService->dataTable();
    }

    public function store(CategoryStoreRequest $request)
    {
        try {
            // self::isAuthorized('category-store');

            $this->categoryService->storeCategory($request);

            return $this->successResponse( 'Category created successfully', []);

        } catch (Exception $e) {

            return $this->errorResponse($e->getMessage());
        }
    }


    public function edit(Request $request)
    {
        $category  = $this->categoryService->findCategory((int)$request->category_id);

        return response()->json(['category'=> $category]);
    }

    public function update(CategoryUpdateRequest $request)
    {
        try {

            $this->categoryService->updateCategory($request);

            return $this->successResponse( 'Data Updated Successfully', []);

        } catch (Exception $e) {

            return $this->errorResponse($e->getMessage());
        }
    }

    public function active(Request $request)
    {
        try {

            $this->categoryService->activeById((int)$request->id);

            return $this->successResponse( 'Data active successfully', []);

        } catch (Exception $e) {

            return $this->errorResponse($e->getMessage());
        }
    }

    public function inactive(Request $request)
    {
        try {

            $this->categoryService->inactiveById((int)$request->id);

            return $this->successResponse( 'Data Inactive successfully', []);

        } catch (Exception $e) {

            return $this->errorResponse($e->getMessage());
        }
    }

    public function delete(Request $request)
    {
        try {

            $this->categoryService->destroy((int) $request->id);

            return $this->successResponse( 'Data Deleted successfully', []);

        } catch (Exception $e) {

            return $this->errorResponse($e->getMessage());
        }
    }


    public function bulkAction(Request $request)
    {
        try {

            $getMessage = $this->categoryService->bulkActionByTypeAndIds((string)$request->action_type, (array)$request->idsArray);

            return $this->successResponse( $getMessage, []);

        } catch (Exception $e) {

            return $this->errorResponse($e->getMessage());
        }
    }


    private function isAuthorized($value) : void
    {
        if (!auth()->user()->can($value)) {
            throw new Exception("403 | You are unauthorized");
        }
    }
}