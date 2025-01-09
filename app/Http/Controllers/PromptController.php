<?php

namespace App\Http\Controllers;

use App\Models\Prompt;
use App\Models\PromptCard;
use App\Models\PromptTool;
use App\Models\PromptToolTagging;
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

        $use_tools = explode(',', $request->input('use_tools'));

        $prompt->title = $request->input('title');
        $prompt->positive_prompt = $request->input('positive_prompt');
        $prompt->negative_prompt = $request->input('negative_prompt');
        $prompt->is_nsfw = $request->input('is_nsfw') == 'on' ? 1 : 0;
        $prompt->created_by = auth()->user()->id;
        $prompt->updated_by = auth()->user()->id;



        if ($prompt->save()) {
            // @TODO: Lucky - not working tool tagging.
            // tool tagging
            if( is_array($use_tools) && count($use_tools) > 0 ) {
                foreach($use_tools as $tool) {
                    // check if tool exists
                    $tool_exists = PromptTool::where('name', $tool)->first();
                    if($tool_exists == null) {
                        $new_tool = new PromptTool;
                        $new_tool->name = $tool;
                        $new_tool->save();
                        $prompt_tool_tagging = new PromptToolTagging;
                        $prompt_tool_tagging->prompt_id = $prompt->id;
                        $prompt_tool_tagging->prompt_tool_id = $new_tool->id;
                        $prompt_tool_tagging->save();
                    } else {
                        $prompt_tool_tagging = new PromptToolTagging;
                        $prompt_tool_tagging->prompt_id = $prompt->id;
                        $prompt_tool_tagging->prompt_tool_id = $tool_exists->id;
                        $prompt_tool_tagging->save();
                    }
                }
            }

            // @TODO: Lucky - not working category tagging.
            // category tagging
            $categories = $request->input('categories');
            if( is_array($categories) && count($categories) > 0 ) {
                foreach($categories as $category) {
                    $prompt->tagging()->create([
                        'category_id' => $category
                    ]);
                }
            }

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
