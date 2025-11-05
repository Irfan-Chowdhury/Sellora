<?php

namespace App\Services;

use App\Enums\ImageDirectory;
use App\Models\Brand;
use App\Traits\ImageHandleTrait;
use App\Traits\SlugTrait;
use App\Traits\WordCheckTrait;
use Illuminate\Support\Facades\DB;
use App\Services\StatusHandlerService;

class BrandService extends StatusHandlerService
{
    use SlugTrait, ImageHandleTrait;

    private static $directory = 'uploads/images/brands/';

    private static $type = 'brand';


    public function getAll()
    {
        $brands = Brand::orderBy('is_active','DESC')
            ->orderBy('id', 'DESC')
            ->get()
            ->map(function($brand)  {
                return [
                    'id'=> $brand->id,
                    'slug'=> $brand->slug,
                    'image'=> $brand->small_image_url,
                    'is_active'=> $brand->is_active,
                    'name'=> $brand->name ?? null,
                ];
            });

        return json_decode(json_encode($brands), FALSE);
    }

    public function dataTable(array $brands)
    {
        return datatables()->of($brands)
            ->setRowId(function ($brand) {
                return $brand->id;
            })
            ->addColumn('image', function ($row){
                return  '<img src="'. $row->image .'" height="50px" width="50px"/>';
            })
            ->addColumn('name', function ($brand){
                return ucfirst ($brand->name);
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
            ->rawColumns(['is_active','action','image'])
            ->make(true);
    }

    public function save($request)
    {
        DB::transaction(function () use ($request) {

            $data = $this->requestHandleData($request);

            Brand::create($data);
        });
    }



    public function findData(Brand $brand)
    {
        return [
            'id' => $brand->id,
            'slug' => $brand->slug,
            'name' => $brand->name,
            'image' => $brand->medium_image_url,
            'isActive' => $brand->is_active
        ];
    }

    public function updateData($request, Brand $brand)
    {
        $requestData = $this->requestHandleData($request, $brand);

        $brand->update($requestData);
    }



    public function requestHandleData($request, $brand = null)
    {
        $data = [
            'name' => $request->name,
            'slug' => $this->slug(htmlspecialchars_decode($request->name)),
            'is_active' => ($request->is_active==true) ? $request->is_active : 0
        ];

        if ($request->image) {
            if ($brand) {
                $this->previousImageDelete(ImageDirectory::BRAND->value.'small/'.$brand->image);
                $this->previousImageDelete(ImageDirectory::BRAND->value.'medium/'.$brand->image);
                $this->previousImageDelete(ImageDirectory::BRAND->value.'large/'.$brand->image);
            }
            $data['image'] = $this->imageStore($request->image, ImageDirectory::BRAND, 300, 300, true, true, true);
        }

        return $data;
    }


    public function active(object $brand): void
    {
        $brand->update(['is_active'=>true]);
    }

    public function inactive(object $brand): void
    {
        $brand->update(['is_active'=>false]);
    }


    public function destroy(object $brand): void
    {
        $this->previousImageDelete(ImageDirectory::BRAND->value.'small/'.$brand->image);
        $this->previousImageDelete(ImageDirectory::BRAND->value.'medium/'.$brand->image);
        $this->previousImageDelete(ImageDirectory::BRAND->value.'large/'.$brand->image);

        $brand->delete();
    }

    public function bulkActionByTypeAndIds(string $actionType, array $ids): string
    {
        $data = Brand::whereIn('id',$ids);

        if ($actionType == 'active') {

            $data->update(['is_active' => 1]);

            return 'Data Active Successfully';

        } else if ($actionType == 'inactive') {

            $data->update(['is_active' => 0]);

            return 'Data Inactive Successfully';

        } else if ($actionType == 'delete') {

            $data->delete();

            return 'Data Deleted Successfully';
        }
    }
}
