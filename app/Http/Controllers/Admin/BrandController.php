<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Brand\BrandStoreRequest;
use App\Http\Requests\Brand\BrandUpdateRequest;
use App\Models\Brand;
use App\Services\BrandService;
use Exception;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    private $brandService;
    public function __construct(BrandService $brandService){
        $this->brandService = $brandService;
    }



    public function index()
    {
        $brands =  $this->brandService->getAll();

        if (request()->ajax()) {
            return $this->brandService->dataTable($brands);
        }

        return view('admin.pages.brand.index', compact('brands'));
    }


    public function create()
    {
        //
    }


    public function store(BrandStoreRequest $request)
    {
        try {

            $this->brandService->save($request);

            return $this->successResponse( 'Brand created successfully', []);

        } catch (Exception $e) {

            return $this->errorResponse($e->getMessage());
        }
    }


    public function show(Brand $brand)
    {
        //
    }

    public function edit(Brand $brand)
    {
        try {

            $brand = $this->brandService->findData($brand);

            return $this->successResponse( null, $brand);

        } catch (Exception $e) {

            return $this->errorResponse($e->getMessage());
        }
    }


    public function update(BrandUpdateRequest $request, Brand $brand)
    {
        try {

            $this->brandService->updateData($request, $brand);

            return $this->successResponse( 'Data Updated Successfully', []);

        } catch (Exception $e) {

            return $this->errorResponse($e->getMessage());
        }
    }

    public function destroy(Brand $brand)
    {
        try {

            $this->brandService->destroy($brand);

            return $this->successResponse( 'Data Deleted successfully', []);

        } catch (Exception $e) {

            return $this->errorResponse($e->getMessage());
        }
    }

    public function makeActive(Brand $brand)
    {
        try {

            $this->brandService->active($brand);

            return $this->successResponse( 'Data active successfully', []);

        } catch (Exception $e) {

            return $this->errorResponse($e->getMessage());
        }
    }

    public function makeInactive(Brand $brand)
    {
        try {

            $this->brandService->inactive($brand);

            return $this->successResponse( 'Data inactive successfully', []);

        } catch (Exception $e) {

            return $this->errorResponse($e->getMessage());
        }
    }

    public function bulkAction(Request $request)
    {
        try {

            $getMessage = $this->brandService->bulkActionByTypeAndIds((string)$request->action_type, (array)$request->idsArray);

            return $this->successResponse( $getMessage, []);

        } catch (Exception $e) {

            return $this->errorResponse($e->getMessage());
        }
    }
}
