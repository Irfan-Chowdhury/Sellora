<?php

namespace App\Services;

use App\Models\Tax;
use App\Traits\SlugTrait;
use Illuminate\Support\Facades\DB;

class TaxService
{
    use SlugTrait;

    public function getAll()
    {
        $taxes = Tax::orderBy('is_active','DESC')
            ->orderBy('id', 'DESC')
            ->get()
            ->map(function($row)  {
                return [
                    'id'=> $row->id,
                    'name'=> $row->name,
                    'rate'=> $row->rate,
                    'is_active'=> $row->is_active,
                ];
            });

        return json_decode(json_encode($taxes), FALSE);
    }

    public function dataTable(array $taxes)
    {
        return datatables()->of($taxes)
            ->setRowId(function ($row) {
                return $row->id;
            })
            ->addColumn('name', function ($row){
                return ucfirst ($row->name);
            })
            ->addColumn('rate', function ($row){
                return $row->rate;
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
            ->rawColumns(['is_active','action'])
            ->make(true);
    }

    public function save($request)
    {
        DB::transaction(function () use ($request) {

            $data = $this->requestHandleData($request);

            Tax::create($data);
        });
    }

    public function findData(Tax $tax)
    {
        return [
            'id' => $tax->id,
            'name' => $tax->name,
            'rate' => $tax->rate,
            'isActive' => $tax->is_active
        ];
    }

    public function updateData($request, Tax $tax)
    {
        $requestData = $this->requestHandleData($request);

        $tax->update($requestData);
    }



    public function requestHandleData($request)
    {
        return [
            'name' => $request->name,
            'rate' => $request->rate,
            'is_active' => ($request->is_active==true) ? $request->is_active : 0
        ];
    }


    public function active(object $tag): void
    {
        $tag->update(['is_active'=>true]);
    }

    public function inactive(object $tag): void
    {
        $tag->update(['is_active'=>false]);
    }


    public function destroy(object $tag): void
    {
        $tag->delete();
    }

    public function bulkActionByTypeAndIds(string $actionType, array $ids): string|null
    {
        $data = Tax::whereIn('id',$ids);

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
        return null;
    }
}

