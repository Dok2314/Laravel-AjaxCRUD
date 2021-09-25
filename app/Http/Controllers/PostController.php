<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(){
        return view('ajax.index');
    }
    public function allData(){
        $data = Post::orderBy('id','DESC')->get();
        return response()->json($data);
    }
    public function addData(Request $request){
        $request->validate([
            'name' => 'required|String',
            'email' => 'required|email',
            'message' => 'required',
        ]);
        $data = Post::insert([
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
        ]);
        return response()->json($data);
    }
    public function editData($id){
        $data = Post::findOrFail($id);
        return response()->json($data);
    }
    public function updateData(Request $request,$id){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required',
        ]);
        $data = Post::findOrFail($id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
        ]);
        return response()->json($data);
    }
    public function deleteData(Request $request,$id){
        $data = Post::findOrFail($id)->delete();
        return response()->json($data);
    }
}

