<?php

namespace App\Http\Controllers;

use App\Helpers\ActorHelper;
use App\Helpers\ApiResponse;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Http\Resources\CourseResource;
use App\Models\Activity;
use App\Models\Course;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all data
        $courses = Course::latest()->paginate(10);
        // transform data
        $response = CourseResource::collection($courses);
        // return response
        return ApiResponse::success($response);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourseRequest $request)
    {
        try {
            // validated response
            $data = $request->validated();
            $data['created_by'] = ActorHelper::getUserId();
            $course = Course::create($data);
            
            // log activity
            info('Course created', [$course]);
            Activity::create([
                'user_id' => ActorHelper::getUserId(),
                'description' => 'created Course',
                'logs' => $course
            ]);

            // commit transaction
            DB::commit();
            // transform data
            $response = new CourseResource($course);
            // return response
            return ApiResponse::success($response);

        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            // log error
            Log::error('Failed to create Course', [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
            ]);
            // return error response
            return ApiResponse::error([], 'Course creation failed ' . $th->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        // transform data
        $response = new CourseResource($course);
        // return response
        return ApiResponse::success($response);    
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCourseRequest $request, Course $course)
    {
        try {
            // validated response
            $data = $request->validated();
            $data['updated_by'] = ActorHelper::getUserId();
            $course->update($data);

            // log activity
            info('Course updated', [$course]);
            Activity::create([
                'user_id' => ActorHelper::getUserId(),
                'description' => 'updated course',
                'logs' => $course
            ]);

            // commit transaction
            DB::commit();
            // transform data
            $response = new CourseResource($course);
            // return response
            return ApiResponse::success($response);

        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            // log error
            Log::error('Failed to update course', [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
            ]);
            // return error response
            return ApiResponse::error([], 'course update failed ' . $th->getMessage(), 500);
        }    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        $course->deleted_by = ActorHelper::getUserId();
        $course->save();
        $course->delete();
        return ApiResponse::success([], 'course deleted');        
    }
}
