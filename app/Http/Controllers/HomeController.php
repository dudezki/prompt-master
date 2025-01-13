<?php

namespace App\Http\Controllers;

use App\Models\Prompt;
use App\Models\PromptCategory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class HomeController extends Controller
{
    protected array $data = [];
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @param Request $request
     * @return Application|Factory|View|JsonResponse
     */
    public function index(Request $request) : Application|Factory|View|JsonResponse
    {
        if( $request->ajax() ) {
            $prompt = Prompt::with(['tagging.category', 'cards' => function($query) {
                    $query->select('id', 'file_name', 'title', 'prompt_id'); // Include 'prompt_id'
                }])
                ->where('status', 'active')
                ->orderBy('id', 'desc')
                ->get();


            $this->data['count'] = $prompt->count();
            $this->data['items'] = $prompt->toArray();

            return response()->json($this->data);
        }

        $this->data['categories'] = PromptCategory::all();

        return view('home', $this->data);
    }

}
