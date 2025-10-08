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

        return view('lte.admin.pages.category.index', compact('categories'));
    }

    public function dataTable(){
        return $this->categoryService->dataTable();
    }

    public function store(CategoryStoreRequest $request)
    {
        try {

            self::isAuthorized('category-store');

            $this->categoryService->storeCategory($request);

            return $this->sendResponse( 'Category created successfully');

        } catch (Exception $e) {

            return $this->sendError($e->getMessage());
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

            self::isAuthorized('category-edit');

            $this->categoryService->updateCategory($request);

            return $this->sendResponse( 'Data Updated Successfully');

        } catch (Exception $e) {

            return $this->sendError($e->getMessage());
        }
    }

    public function active(Request $request)
    {
        try {

            self::isAuthorized('category-action');

            $this->categoryService->activeById((int)$request->id);

            return $this->sendResponse( 'Data Inactive Successfully');

        } catch (Exception $e) {

            return $this->sendError($e->getMessage());
        }
    }

    public function inactive(Request $request)
    {
        try {
            self::isAuthorized('category-action');

            $this->categoryService->inactiveById((int)$request->id);

            return $this->sendResponse( 'Data Inactive Successfully');

        } catch (Exception $e) {

            return $this->sendError($e->getMessage());
        }
    }

    public function delete(Request $request)
    {
        try {

            self::isAuthorized('category-action');

            $this->categoryService->destroy((int) $request->id);

            // return response()->json(['success' => 'Data Deleted Successfully']);
            return $this->sendResponse( 'Data Deleted Successfully');

        } catch (Exception $e) {

            // return response()->json(['errors' => [$e->getMessage()]], 422);
            return $this->sendError($e->getMessage());
        }
    }


    public function bulkAction(Request $request)
    {
        try {
            self::isAuthorized('category-action');

            $getMessage = $this->categoryService->bulkActionByTypeAndIds((string)$request->action_type, (array)$request->idsArray);

            return $this->sendResponse( $getMessage);

        } catch (Exception $e) {

            return $this->sendError($e->getMessage());
        }
    }


    private function isAuthorized($value) : void
    {
        if (!auth()->user()->can($value)) {
            throw new Exception("403 | You are unauthorized");
        }
    }
}








        //--------- Test  -----------
        // $categories = Category::with('categoryTranslations')
        //     ->get();
        // $data = [];
        // foreach ($categories as $key => $value) {
        //     $data[$key]['slug']  = $value->slug;
        //     $data[$key]['local'] = $this->translations($value->categoryTranslations)->local;
        //     $data[$key]['category_name'] = $this->translations($value->categoryTranslations)->category_name;
        // }
        // return $data;
        // return $this->translations($category->categoryTranslation);

        //Trait
        // namespace App\Trait;
        // trait Residence{
        // }

        // //Class
        // namespace App\Controller;
        // use App\Trait\Residence;
        // Class TraitClassForBlade{
        //     use Residence;
        // }

        // //Blade
        // @inject('Residence','App\Controller\TraitClassForBlade')
        // @foreach($residence->country as $country)
        // @endforeach
        //--------- Test  -----------
