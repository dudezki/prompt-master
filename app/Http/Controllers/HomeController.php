<?php

namespace App\Http\Controllers;

use App\Models\Prompt;
use App\Models\PromptCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::check()) {

            $this->data['items'] = Prompt::all();
            $this->data['categories'] = PromptCategory::all();

            return view('home', $this->data);
        }
        return view('auth.login');
    }
}
