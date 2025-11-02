<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\Category\CategoryContract;
use App\Contracts\Category\CategoryTranslationContract;
use App\Enums\ImageDirectory;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Models\CategoryTranslation;
use App\Traits\WordCheckTrait;
use App\Traits\ImageHandleTrait;
use App\Traits\SlugTrait;
use Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Services\StatusHandlerService;
use Illuminate\Support\Facades\Storage;
use Image;

class CategoryService extends StatusHandlerService
{
    use SlugTrait, ImageHandleTrait, WordCheckTrait;

    private static $directory = 'uploads/images/categories/';

    private static $type = 'category';


    public function getAllCategories()
    {
        $categories = Category::orderBy('is_active','DESC')
            ->orderBy('id','ASC')
            ->get()
            ->map(function($category)  {
                return [
                    'id'=> $category->id,
                    'slug'=> $category->slug,
                    'image'=> $category->small_image_url,
                    // 'image'=> $category->image,
                    'is_active'=> $category->is_active,
                    'category_name'=> $category->name ?? null,
                    'parent_category_name'=> $category->parentCategory->name ?? 'NONE',
                ];
            });


        return json_decode(json_encode($categories), FALSE);
    }

    public function dataTable()
    {
        $categories = self::getAllCategories();

        if (request()->ajax()){

            return datatables()->of($categories)
                    ->setRowId(function ($category){
                        return $category->id;
                    })
                    ->addColumn('category_image', function ($row){
                        return  '<img src="'. $row->image .'" height="50px" width="50px"/>';
                    })
                    ->addColumn('category_name', function ($row){
                        return $row->category_name;
                    })
                    ->addColumn('parent', function ($row){
                        return $row->parent_category_name;
                    })
                    ->addColumn('is_active', function ($row){
                        if($row->is_active==1){
                            return '<span class="p-2 badge badge-success">Active</span>';
                        }else {
                            return '<span class="p-2 badge badge-danger">Inactive</span>';
                        }
                    })
                    ->addColumn('action', function ($row){
                        $actionBtn = "";

                        $actionBtn .= '<button type="button" title="Edit" class="edit btn btn-info btn-sm" title="Edit" data-id="'.$row->id.'"><i class="dripicons-pencil"></i></button>
                                        &nbsp; ';

                        if ($row->is_active==1) {
                            $actionBtn .= '<button type="button" title="Inactive" class="inactive btn btn-warning btn-sm" data-id="'.$row->id.'"><i class="fa fa-thumbs-down"></i></button>';
                        }else {
                            $actionBtn .= '<button type="button" title="Active" class="active btn btn-success btn-sm" data-id="'.$row->id.'"><i class="fa fa-thumbs-up"></i></button>';
                        }
                        $actionBtn .= '<button type="button" title="Delete" class="delete btn btn-danger btn-sm ml-2" title="Edit" data-id="'.$row->id.'"><i class="dripicons-trash"></i></button>
                        &nbsp; ';

                        return $actionBtn;
                    })
                    ->rawColumns(['is_active','action','category_image'])
                    ->make(true);
        }
    }

    public function storeCategory($request)
    {
        DB::transaction(function () use ($request) {

            $data = $this->requestHandleData($request);

            Category::create($data);
        });
    }

    public function findCategory(int $id)
    {
        try {
            $category = Category::findOrFail($id);

            return new CategoryResource($category);

        } catch (Exception $e) {

            throw new Exception($e->getMessage());
        }
    }

    public function updateCategory($request)
    {
        DB::beginTransaction();
        try {

            $category = $this->findCategory((int)$request->category_id);

            $requesteData = $this->requestHandleData($request, $category);

            Category::whereId($request->category_id)->update($requesteData);

            DB::commit();

        } catch (Exception $e) {

            DB::rollBack();

            throw new Exception($e->getMessage());
        }
    }


    public function requestHandleData($request, $category = null){
        $data              = [];
        $data['name']      = $request->name;
        $data['slug']      = $this->slug(htmlspecialchars_decode($request->name));
        $data['parent_id'] = ($request->parent_id==true) ? $request->parent_id : null;
        $data['icon']      = ($request->icon==true) ? $request->icon : null;
        $data['top']       = ($request->top==true) ? $request->top : 0;
        $data['is_active'] = ($request->is_active==true) ? $request->is_active : 0;
        if ($request->image) {
            if ($category) {
                $this->previousImageDelete(ImageDirectory::CATEGORY->value.'small/'.$category->image);
                $this->previousImageDelete(ImageDirectory::CATEGORY->value.'medium/'.$category->image);
                $this->previousImageDelete(ImageDirectory::CATEGORY->value.'large/'.$category->image);
            }
            $data['image'] = $this->imageStore($request->image, ImageDirectory::CATEGORY, 300, 300, true, true, false);
        }
        return $data;
    }


    public function activeById(int $id): void
    {
        $this->activeData(Category::findOrFail($id));

    }

    public function inactiveById(int $id): void
    {
        $this->inactiveData(Category::findOrFail($id));
    }



    public function destroy($categoryId): void
    {
        $category = Category::findOrFail($categoryId);
        $this->previousImageDelete(ImageDirectory::CATEGORY->value.'small/'.$category->image);
        $this->previousImageDelete(ImageDirectory::CATEGORY->value.'medium/'.$category->image);
        $category->delete();
    }

    public function bulkActionByTypeAndIds(string $type, array $ids)
    {
        return $this->bulkActionData($type, Category::whereIn('id',$ids));
    }

    public function existingImageConvertToNew()
    {
        $categories =  Category::select('id','image')->get();

        foreach ($categories as $category) {
            try {
                    if (!$category->image) {
                      continue;
                    }

                    $existingFile = public_path($category->image);

                    if (file_exists($existingFile)) {

                        $fileName = $this->imageStore($existingFile, ImageDirectory::CATEGORY, 300, 300, true, $isMedium = true, $isLarge = false);
                        $category->image = $fileName;
                        $category->save();
                    }
            } catch (Exception $e) {
                dd($e->getMessage()." id: {$category->id}");
            }
        }

        dd("Converted and stored: ");
    }
}

