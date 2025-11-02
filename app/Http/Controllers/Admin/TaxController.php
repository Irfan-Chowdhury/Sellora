<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tax\TaxStoreRequest;
use App\Http\Requests\Tax\TaxUpdateRequest;
use App\Models\Tax;
use App\Services\TaxService;
use Exception;
use Illuminate\Http\Request;

class TaxController extends Controller
{
    private $taxService;
    public function __construct(TaxService $taxService){
        $this->taxService = $taxService;
    }

    public function index()
    {
        $tags =  $this->taxService->getAll();

        if (request()->ajax()) {
            return $this->taxService->dataTable($tags);
        }

        return view('admin.pages.taxes.index');
    }


    public function create()
    {
        //
    }


    public function store(TaxStoreRequest $request)
    {
        try {

            $this->taxService->save($request);

            return $this->successResponse( 'Data created successfully', []);

        } catch (Exception $e) {

            return $this->errorResponse($e->getMessage());
        }
    }


    public function show(Tax $tax)
    {
        //
    }

    public function edit(Tax $tax)
    {
        try {

            $brand = $this->taxService->findData($tax);

            return $this->successResponse( null, $brand);

        } catch (Exception $e) {

            return $this->errorResponse($e->getMessage());
        }
    }


    public function update(TaxUpdateRequest $request, Tax $tax)
    {
        try {

            $this->taxService->updateData($request, $tax);

            return $this->successResponse( 'Data Updated Successfully', []);

        } catch (Exception $e) {

            return $this->errorResponse($e->getMessage());
        }
    }

    public function destroy(Tax $tax)
    {
        try {

            $this->taxService->destroy($tax);

            return $this->successResponse( 'Data Deleted successfully', []);

        } catch (Exception $e) {

            return $this->errorResponse($e->getMessage());
        }
    }

    public function makeActive(Tax $tax)
    {
        try {

            $this->taxService->active($tax);

            return $this->successResponse( 'Data active successfully', []);

        } catch (Exception $e) {

            return $this->errorResponse($e->getMessage());
        }
    }

    public function makeInactive(Tax $tax)
    {
        try {

            $this->taxService->inactive($tax);

            return $this->successResponse( 'Data inactive successfully', []);

        } catch (Exception $e) {

            return $this->errorResponse($e->getMessage());
        }
    }

    public function bulkAction(Request $request)
    {
        try {

            $getMessage = $this->taxService->bulkActionByTypeAndIds((string)$request->action_type, (array)$request->idsArray);

            return $this->successResponse( $getMessage, []);

        } catch (Exception $e) {

            return $this->errorResponse($e->getMessage());
        }
    }
}
