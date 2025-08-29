<?php

namespace App\Http\Controllers;

use App\Helpers\ActorHelper;
use App\Helpers\ApiResponse;
use App\Http\Requests\StoreQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;
use App\Http\Resources\QuestionResource;
use App\Models\Activity;
use App\Models\Question;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all data
        $questions = Question::latest()->paginate(10);
        // transform data
        $response = QuestionResource::collection($questions);
        // return response
        return ApiResponse::success($response, 'successful', 200, $questions);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreQuestionRequest $request)
    {
        try {
            // validated response
            $data = $request->validated();
            $data['created_by'] = ActorHelper::getUserId();
            $question = Question::create($data);
            
            // log activity
            info('Question created', [$question]);
            Activity::create([
                'user_id' => ActorHelper::getUserId(),
                'description' => 'created Question',
                'log' => $question
            ]);

            // commit transaction
            DB::commit();
            // transform data
            $response = new QuestionResource($question);
            // return response
            return ApiResponse::success($response);

        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            // log error
            Log::error('Failed to create Question', [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
            ]);
            // return error response
            return ApiResponse::error([], 'Question creation failed ' . $th->getMessage(), 500);
        }    
    }

    /**
     * Display the specified resource.
     */
    public function show(Question $question)
    {
        // transform data
        $response = new QuestionResource($question);
        // return response
        return ApiResponse::success($response);          
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateQuestionRequest $request, Question $question)
    {
        try {
            // validated response
            $data = $request->validated();
            $data['updated_by'] = ActorHelper::getUserId();
            $question->update($data);

            // log activity
            info('Question updated', [$question]);
            Activity::create([
                'user_id' => ActorHelper::getUserId(),
                'description' => 'updated question',
                'log' => $question
            ]);

            // commit transaction
            DB::commit();
            // transform data
            $response = new QuestionResource($question);
            // return response
            return ApiResponse::success($response);

        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            // log error
            Log::error('Failed to update question', [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
            ]);
            // return error response
            return ApiResponse::error([], 'question update failed ' . $th->getMessage(), 500);
        }         
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question)
    {
        $question->deleted_by = ActorHelper::getUserId();
        $question->save();
        $question->delete();
        return ApiResponse::success([], 'question deleted');          
    }
}
