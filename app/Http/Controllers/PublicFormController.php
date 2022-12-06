<?php

namespace App\Http\Controllers;

use App\Models\FormRender;
use Illuminate\Http\Request;

class PublicFormController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $form_render = FormRender::where('status', 1)->get();

        return view('public_form', compact("form_render"));
    }
}
