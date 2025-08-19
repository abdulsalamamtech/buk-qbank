<?php

namespace App\Http\Controllers;

use App\Helpers\ActorHelper;
use App\Helpers\ApiResponse;
use App\Http\Requests\StoreGeneratedQuestionRequest;
use App\Http\Requests\UpdateGeneratedQuestionRequest;
use App\Http\Resources\GeneratedQuestionResource;
use App\Models\Activity;
use App\Models\GeneratedQuestion;
use App\Models\Question;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GeneratedQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all data
        $generated_questions = GeneratedQuestion::latest()->paginate(10);
        // transform data
        $response = GeneratedQuestionResource::collection($generated_questions);
        // return response
        return ApiResponse::success($response);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGeneratedQuestionRequest $request)
    {
        try {
            // validated response
            $data = $request->validated();
            $data['created_by'] = ActorHelper::getUserId();

            // selecting objective question from DB
            // objective_total
            // 'objective_questions',
            $objective_total = $data['objective_total'];
            $random_objective_questions = Question::where('type', 'objective')->inRandomOrder()->take($objective_total)->get();
            $objective_questions = $random_objective_questions->pluck('id'); // Get only the IDs

            // selecting theory question from DB
            // theory_total
            // 'theory_questions', 
            $theory_total = $data['theory_total'];
            $random_theory_questions = Question::where('type', 'theory')->inRandomOrder()->take($theory_total)->get();
            $theory_questions = $random_theory_questions->pluck('id'); // Get only the IDs

            $data['objective_questions'] = $objective_questions;
            $data['theory_questions'] = $theory_questions;

            $generated_question = GeneratedQuestion::create($data);

            // log activity
            info('GeneratedQuestion created', [$generated_question]);
            Activity::create([
                'user_id' => ActorHelper::getUserId(),
                'description' => 'created generated question',
                'log' => $generated_question
            ]);

            // commit transaction
            DB::commit();
            // transform data
            $response = new GeneratedQuestionResource($generated_question);
            // return response
            return ApiResponse::success($response);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            // log error
            Log::error('Failed to create generated question', [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
            ]);
            // return error response
            return ApiResponse::error([], 'Generated question creation failed ' . $th->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(GeneratedQuestion $generatedQuestion)
    {
        // transform data
        $response = new GeneratedQuestionResource($generatedQuestion);
        // return response
        return ApiResponse::success($response);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGeneratedQuestionRequest $request, GeneratedQuestion $generatedQuestion)
    {
        try {
            // validated response
            $data = $request->validated();
            $data['updated_by'] = ActorHelper::getUserId();
            // $generatedQuestion->update($data);

            // log activity
            info('GeneratedQuestion updated', [$generatedQuestion]);
            Activity::create([
                'user_id' => ActorHelper::getUserId(),
                'description' => 'updated generated question',
                'log' => $generatedQuestion
            ]);

            // commit transaction
            DB::commit();
            // transform data
            $response = new GeneratedQuestionResource($generatedQuestion);
            // return response
            return ApiResponse::success($response);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            // log error
            Log::error('Failed to update generated question', [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
            ]);
            // return error response
            return ApiResponse::error([], 'generated question update failed ' . $th->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GeneratedQuestion $generatedQuestion)
    {
        $generatedQuestion->deleted_by = ActorHelper::getUserId();
        $generatedQuestion->save();
        $generatedQuestion->delete();
        return ApiResponse::success([], 'generated question deleted');
    }


    /**
     * Export generated Pdf  specified resource.
     */
    public function generatePdf(GeneratedQuestion $generatedQuestion)
    {

        // 'question_type',
        // 'year',
        // 'course_id',
        // 'level',
        // 'semester',

        // 'objective_instruction',
        // 'objective_total',
        // 'objective_questions',

        // 'theory_instruction',
        // 'theory_total',
        // 'theory_questions',

        // get data relationship
        $generatedQuestion->load('course.department', 'course.createdBy');
        // transform data
        $response = new GeneratedQuestionResource($generatedQuestion);
        $section_a = Question::whereIn('id', $response->objective_questions)->get();
        $section_b = Question::whereIn('id', $response->theory_questions)->get();

        // return response
        // return[ $response, $section_a, $section_b ];

        $pdf = Pdf::loadView('pdf.generate-questions', [
            'q' => $response,
            'section_a' => $section_a,
            'section_b' => $section_b,
        ]);

        // return $pdf->download('exam-questions.pdf');        

        return $pdf->stream('exam-questions.pdf');
    }
}
