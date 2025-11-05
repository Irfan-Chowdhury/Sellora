<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Tag;
use App\Traits\SlugTrait;
use Illuminate\Support\Facades\DB;

class TagService
{
    use SlugTrait;

    public function getAll()
    {
        $tags = [];
        Tag::orderBy('is_active', 'DESC')
        ->orderBy('id', 'DESC')
        ->chunk(500, function ($rows) use (&$tags) {
            foreach ($rows as $tag) {
                $tags[] = [
                    'id'        => $tag->id,
                    'slug'      => $tag->slug,
                    'name'      => $tag->name,
                    'is_active' => $tag->is_active,
                ];
            }
        });

        return json_decode(json_encode($tags), FALSE);
    }

    public function dataTable(array $tags)
    {
        return datatables()->of($tags)
            ->setRowId(function ($row) {
                return $row->id;
            })
            ->addColumn('name', function ($row){
                return ucfirst ($row->name);
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

            Tag::create($data);
        });
    }

    public function findData(Tag $tag)
    {
        return [
            'id' => $tag->id,
            'slug' => $tag->slug,
            'name' => $tag->name,
            'isActive' => $tag->is_active
        ];
    }

    public function updateData($request, Tag $tag)
    {
        $requestData = $this->requestHandleData($request, $tag);

        $tag->update($requestData);
    }



    public function requestHandleData($request, $tag = null)
    {
        return [
            'name' => $request->name,
            'slug' => $this->slug(htmlspecialchars_decode($request->name)),
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
        $data = Tag::whereIn('id',$ids);

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
