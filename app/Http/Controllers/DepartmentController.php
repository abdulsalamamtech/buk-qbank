<?php

namespace App\Http\Controllers;

use App\Helpers\ActorHelper;
use App\Helpers\ApiResponse;
use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Http\Resources\DepartmentResource;
use App\Models\Activity;
use App\Models\Department;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all data
        $departments = Department::latest()->paginate(10);
        // transform data
        $response = DepartmentResource::collection($departments);
        // return response
        return ApiResponse::success($response);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDepartmentRequest $request)
    {
        try {
            // validated response
            $data = $request->validated();
            $department = Department::create($data);
            
            // log activity
            info('department created', [$department]);
            Activity::create([
                'user_id' => ActorHelper::getUserId(),
                'description' => 'created department',
                'logs' => $department
            ]);

            // commit transaction
            DB::commit();
            // transform data
            $response = new DepartmentResource($department);
            // return response
            return ApiResponse::success($response);

        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            // log error
            Log::error('Failed to create department', [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
            ]);
            // return error response
            return ApiResponse::error([], 'Department creation failed ' . $th->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        // transform data
        $response = new DepartmentResource($department);
        // return response
        return ApiResponse::success($response);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDepartmentRequest $request, Department $department)
    {
        try {
            // validated response
            $data = $request->validated();
            $department->update($data);

            // log activity
            info('department updated', [$department]);
            Activity::create([
                'user_id' => ActorHelper::getUserId(),
                'description' => 'updated department',
                'logs' => $department
            ]);

            // commit transaction
            DB::commit();
            // transform data
            $response = new DepartmentResource($department);
            // return response
            return ApiResponse::success($response);

        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            // log error
            Log::error('Failed to update department', [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
            ]);
            // return error response
            return ApiResponse::error([], 'Department update failed ' . $th->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        $department->delete();
        return ApiResponse::success([], 'department deleted');
    }
}
