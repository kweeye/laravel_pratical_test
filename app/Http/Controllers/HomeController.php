<?php

namespace App\Http\Controllers;

use App\Models\FormRender;
use Illuminate\Http\Request;

class HomeController extends Controller
{
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
        $form_render = FormRender::get();
        
        return view('home', compact("form_render"));
    }

    /**
     * Insert the form render.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function store(Request $request)
    {
        $update_arr = $request->get('form_fields');
        if($update_arr){
            $insert_render = FormRender::whereIn('id',$update_arr)->update(['status' => 1]);
            $delete_render = FormRender::whereNotIn('id',$update_arr)->update(['status' => 0]);
        }
        
        return redirect('home');
    }
}
