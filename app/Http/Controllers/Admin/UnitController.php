<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Unit\UnitStoreRequest;
use App\Http\Requests\Unit\UnitUpdateRequest;
use App\Models\Unit;
use App\Services\UnitService;
use Illuminate\Http\Request;
use Exception;

class UnitController extends Controller
{
    private $unitService;
    public function __construct(UnitService $unitService){
        $this->unitService = $unitService;
    }

    public function index()
    {
        $units =  $this->unitService->getAll();

        $baseUnits =  $this->unitService->getOnlyBaseUnits();

        if (request()->ajax()) {
            return $this->unitService->dataTable($units);
        }

        return view('admin.pages.units.index',compact('baseUnits'));
    }


    public function create()
    {
        //
    }


    public function store(UnitStoreRequest $request)
    {
        // return response()->json($request->all());

        try {

            $this->unitService->save($request);

            return $this->successResponse( 'Data created successfully', []);

        } catch (Exception $e) {

            return $this->errorResponse($e->getMessage());
        }
    }


    public function show(Unit $unit)
    {
        //
    }

    public function edit(Unit $unit)
    {
        try {

            $unit = $this->unitService->findData($unit);

            return $this->successResponse( null, $unit);

        } catch (Exception $e) {

            return $this->errorResponse($e->getMessage());
        }
    }


    public function update(UnitUpdateRequest $request, Unit $unit)
    // public function update(Request $request, Unit $unit)
    {
        try {

            $this->unitService->updateData($request, $unit);

            return $this->successResponse( 'Data Updated Successfully', []);

        } catch (Exception $e) {

            return $this->errorResponse($e->getMessage());
        }
    }

    public function destroy(Unit $unit)
    {
        try {

            $this->unitService->destroy($unit);

            return $this->successResponse( 'Data Deleted successfully', []);

        } catch (Exception $e) {

            return $this->errorResponse($e->getMessage());
        }
    }

    public function makeActive(Unit $unit)
    {
        try {

            $this->unitService->active($unit);

            return $this->successResponse( 'Data active successfully', []);

        } catch (Exception $e) {

            return $this->errorResponse($e->getMessage());
        }
    }

    public function makeInactive(Unit $unit)
    {
        try {

            $this->unitService->inactive($unit);

            return $this->successResponse( 'Data inactive successfully', []);

        } catch (Exception $e) {

            return $this->errorResponse($e->getMessage());
        }
    }

    public function bulkAction(Request $request)
    {
        try {

            $getMessage = $this->unitService->bulkActionByTypeAndIds((string)$request->action_type, (array)$request->idsArray);

            return $this->successResponse( $getMessage, []);

        } catch (Exception $e) {

            return $this->errorResponse($e->getMessage());
        }
    }
}
