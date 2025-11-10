<?php

namespace App\Services;

use App\Models\Unit;
use App\Traits\SlugTrait;
use Illuminate\Support\Facades\DB;

class UnitService
{
    use SlugTrait;

    public function getAll()
    {
        $unites = Unit::orderBy('is_active','DESC')
            ->orderBy('id', 'DESC')
            ->get()
            ->map(function($row)  {
                return [
                    'id'=> $row->id,
                    'name'=> $row->name,
                    'code'=> $row->code,
                    'base_unit_id'=> $row->base_unit ?? null,
                    'base_unit_name'=> $row->baseUnit->name ?? "N/A",
                    'operator'=> $row->operator,
                    'operation_value'=> $row->operation_value,
                    'is_active'=> $row->is_active,
                ];
            });

        return json_decode(json_encode($unites), FALSE);
    }

    public function getOnlyBaseUnits()
    {
        $baseUnits = $this->getAll();

        $filteredBaseUnits = collect($baseUnits)->filter(function ($unit) {
            return $unit->base_unit_id === null;
        });

        return $filteredBaseUnits->values(); // Optional: reindex the array
    }


    public function dataTable(array $unites)
    {
        return datatables()->of($unites)
            ->setRowId(function ($row) {
                return $row->id;
            })
            ->addColumn('name', function ($row){
                return ucfirst ($row->name);
            })
            ->addColumn('code', function ($row){
                return $row->code;
            })
            ->addColumn('base_unit', function ($row){
                return $row->base_unit_name;
            })
            ->addColumn('operator', function ($row){
                return $row->operator;
            })

            ->addColumn('operation_value', function ($row){
                return $row->operation_value;
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

            Unit::create($data);
        });
    }

    public function findData(Unit $unit)
    {
        return [
            'id'=> $unit->id,
            'name'=> $unit->name,
            'code'=> $unit->code,
            'base_unit_id'=> $unit->base_unit ?? null,
            'base_unit'=> $unit->baseUnit->name ?? null,
            'operator'=> $unit->operator,
            'operation_value'=> $unit->operation_value,
            'is_active'=> $unit->is_active,
        ];
    }

    public function updateData($request, Unit $unit)
    {
        $requestData = $this->requestHandleData($request);

        $unit->update($requestData);
    }



    public function requestHandleData($request)
    {
        return [
            'name' => $request->name,
            'code' => $request->code,
            'base_unit' => $request->base_unit ? $request->base_unit : null,
            'operator' => $request->base_unit ? $request->operator : '*',
            'operation_value' => $request->base_unit ? $request->operation_value : 1,
            'is_active' => ($request->is_active==true) ? $request->is_active : 0
        ];
    }


    public function active(object $unit): void
    {
        $unit->update(['is_active'=>true]);
    }

    public function inactive(object $unit): void
    {
        $unit->update(['is_active'=>false]);
    }


    public function destroy(object $unit): void
    {
        $unit->delete();
    }

    public function bulkActionByTypeAndIds(string $actionType, array $ids): string|null
    {
        $data = Unit::whereIn('id',$ids);

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