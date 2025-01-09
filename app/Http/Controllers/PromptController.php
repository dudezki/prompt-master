<?php

namespace App\Http\Controllers;

use App\Models\Prompt;
use App\Models\PromptCard;
use Illuminate\Http\Request;

class PromptController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $file_blobs = $request->input('file_blob');

        if($file_blobs == null) {
            return response()->json([
                'status' => 'error',
                'title' => 'Prompt not created',
                'icon' => 'error',
                'message' => 'Prompt not created. Please upload prompt cards.'
            ], 200);
        }
        // create prompt
        $prompt = new Prompt;
        $prompt->title = $request->input('title');
        $prompt->positive_prompt = $request->input('positive_prompt');
        $prompt->negative_prompt = $request->input('negative_prompt');
        $prompt->created_by = auth()->user()->id;
        $prompt->updated_by = auth()->user()->id;

        if ($prompt->save()) {
            // convert the base64 string to blob data to insert in database.

            foreach ($file_blobs as $base64String) {
                // Ensure the base64 string is properly formatted
                $base64String = str_replace(' ', '+', $base64String);

                PromptCard::create([
                    'file' => $base64String,
                    'prompt_id' => $prompt->id
                ]);
            }
        }

        $new_prompt = Prompt::with('tagging.category', 'cards')->find($prompt->id);


        return response()->json([
            'status' => 'success',
            'title' => 'Prompt created',
            'icon' => 'success',
            'message' => 'Prompt created successfully',
            'data' => $request->input(),
            'prompt' => $new_prompt
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $prompt = Prompt::find($id);
        $prompt->status = 'deleted';
        $prompt->save();
        return response()->json([
            'status' => 'success',
            'title' => 'Prompt deleted',
            'icon' => 'success',
            'message' => 'Prompt deleted successfully'
        ], 200);
    }
}
