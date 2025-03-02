<?php

namespace App\Http\Controllers;

use App\Models\AiModel;
use App\Models\Prompt;
use App\Models\PromptCard;
use App\Models\PromptTool;
use App\Models\PromptToolTagging;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class PromptController extends Controller
{
    private array $data = [];

    private int $model_id = 0;
    private int $prompt_id = 0;

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
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $file_blobs = $request->input('file_blob');
        $use_tools = explode(',', $request->input('use_tools'));
        $categories = $request->input('categories') ?? [];

        if (is_null($file_blobs)) {
            return response()->json([
                'status' => 'error',
                'title' => 'Prompt not created',
                'icon' => 'error',
                'message' => 'Prompt not created. Please upload prompt cards.'
            ]);
        }

        DB::beginTransaction();

        try {

            $this->createModel($request);

            $prompt = $this->createPrompt($request);

            $this->tagTools($prompt, $use_tools);
            $this->tagCategories($prompt, $categories);
            $this->createPromptCards($prompt, $file_blobs);

            DB::commit();

            $new_prompt = Prompt::with('tagging.category', 'cards')->find($prompt->id);

            return response()->json([
                'status' => 'success',
                'title' => 'Prompt created',
                'icon' => 'success',
                'message' => 'Prompt created successfully',
                'data' => $new_prompt
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'title' => 'Prompt not created',
                'icon' => 'error',
                'message' => 'Prompt not created. An error occurred: ' . $e->getMessage()
            ]);
        }
    }


    private function createModel(Request $request): void
    {
        $model = AiModel::firstOrCreate(
            ['name' => $request->input('base_model_file_name')],
            ['status' => 'active']
        );

        $this->model_id = $model->id;
    }

    private function createPrompt(Request $request): Prompt
    {
        $prompt = new Prompt;
        $prompt->title = $request->input('title');
        $prompt->positive_prompt = $request->input('positive_prompt');
        $prompt->negative_prompt = $request->input('negative_prompt');
        $prompt->is_nsfw = $request->input('is_nsfw') == 'on' ? 1 : 0;
        $prompt->model_id = $this->model_id;
        $prompt->created_by = auth()->user()->id;
        $prompt->updated_by = auth()->user()->id;
        $prompt->save();

        return $prompt;
    }

    private function tagTools(Prompt $prompt, array $use_tools): void
    {
        foreach ($use_tools as $tool) {
            $tool_exists = PromptTool::firstOrCreate(['name' => $tool]);
            PromptToolTagging::create([
                'prompt_id' => $prompt->id,
                'prompt_tool_id' => $tool_exists->id
            ]);
        }
    }

    private function tagCategories(Prompt $prompt, array $categories): void
    {
        foreach ($categories as $category) {
            $prompt->tagging()->create(['category_id' => $category]);
        }
    }

    private function createPromptCards(Prompt $prompt, array $file_blobs): void
    {
        foreach ($file_blobs as $base64String) {
            $base64String = str_replace(' ', '+', $base64String);
            PromptCard::create([
                'file' => $base64String,
                'prompt_id' => $prompt->id
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $prompt = Prompt::with(['tagging.category', 'tools.tool',
            'cards' => function($query) {
                $query->select('id', 'file_name', 'title', 'prompt_id'); // Include 'prompt_id'
            }
        ])->find($id);

        $cards = $prompt->cards;
        $maxColumns = 3; // Maximum number of columns
        $columns = min($maxColumns, max(1, ceil($cards->count() / 2))); // Adjust columns based on the number of cards
        $cardsPerColumn = ceil($cards->count() / $columns);


        $created_details = '<div class="p-3">';
        $created_details .= '<span class="text-muted">' . \Carbon\Carbon::parse($prompt->created_at)->diffForHumans() . '</span> by ' . $prompt->user->name;
        $created_details .= '</div>';


        $data = [
            'prompt' => $prompt,
            'columns' => $columns,
            'cardsPerColumn' => $cardsPerColumn,
            'cards' => $cards,
            'tools' => $prompt->tools,
            'created_details' => $created_details
        ];

        $view = view('pages.prompt.show', $data)->render();

        return response()->json([
            'view' => $view,
            'data' => $data
        ]);
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
