<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tag\TagStoreRequest;
use App\Http\Requests\Tag\TagUpdateRequest;
use App\Services\TagService;
use Exception;

class TagController extends Controller
{
    private $tagService;
    public function __construct(TagService $tagService){
        $this->tagService = $tagService;
    }

    public function index()
    {
        $tags =  $this->tagService->getAll();

        if (request()->ajax()) {
            return $this->tagService->dataTable($tags);
        }

        return view('admin.pages.tags.index');
    }


    public function create()
    {
        //
    }


    public function store(TagStoreRequest $request)
    {
        try {

            $this->tagService->save($request);

            return $this->successResponse( 'Data created successfully', []);

        } catch (Exception $e) {

            return $this->errorResponse($e->getMessage());
        }
    }


    public function show(Tag $tag)
    {
        //
    }

    public function edit(Tag $tag)
    {
        try {

            $brand = $this->tagService->findData($tag);

            return $this->successResponse( null, $brand);

        } catch (Exception $e) {

            return $this->errorResponse($e->getMessage());
        }
    }


    public function update(TagUpdateRequest $request, Tag $tag)
    {
        try {

            $this->tagService->updateData($request, $tag);

            return $this->successResponse( 'Data Updated Successfully', []);

        } catch (Exception $e) {

            return $this->errorResponse($e->getMessage());
        }
    }

    public function destroy(Tag $tag)
    {
        try {

            $this->tagService->destroy($tag);

            return $this->successResponse( 'Data Deleted successfully', []);

        } catch (Exception $e) {

            return $this->errorResponse($e->getMessage());
        }
    }

    public function makeActive(Tag $tag)
    {
        try {

            $this->tagService->active($tag);

            return $this->successResponse( 'Data active successfully', []);

        } catch (Exception $e) {

            return $this->errorResponse($e->getMessage());
        }
    }

    public function makeInactive(Tag $tag)
    {
        try {

            $this->tagService->inactive($tag);

            return $this->successResponse( 'Data inactive successfully', []);

        } catch (Exception $e) {

            return $this->errorResponse($e->getMessage());
        }
    }

    public function bulkAction(Request $request)
    {
        try {

            $getMessage = $this->tagService->bulkActionByTypeAndIds((string)$request->action_type, (array)$request->idsArray);

            return $this->successResponse( $getMessage, []);

        } catch (Exception $e) {

            return $this->errorResponse($e->getMessage());
        }
    }
}
