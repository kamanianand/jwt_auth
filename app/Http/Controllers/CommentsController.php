<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comments;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api');
    }

    // get all comments
    public function get_all_comment(){

        $comments = Comments::all();

        return response()->json([
            'message' => 'Comment get successfully',
            'status' => 200,
            'data'=>$comments
        ], 201);
    }

    // add new comments
    public function add_comment(Request $request){

        $comments = new Comments;
        $comments->comment  = $request->comment;
        $comments->status    = 1;
        $comments->save();

         return response()->json([
            'message' => 'New comment add successfully',
            'status' => 200,
        ], 201);
    }

    // get sigle comment details
    public function get_single_comment($id){

        $comments = Comments::where('id',$id)->first();
         return response()->json([
            'message' => 'New comment add successfully',
            'status' => 200,
            'data'=>$comments
        ], 201);
    }

    // update comment details
    public function update_comment($id,Request $request){
        // echo $id; die();
        // echo "<pre>"; print_r($request->all()); die();
        $comments = Comments::find($id);
        $comments->comment  = $request->comment;
        $comments->save();

        return response()->json([
            'message' => 'Comment details update successfully',
            'status' => 200,
        ], 201);
    }

    // delete single comment
    public function delete_comment($id){

        $comments = Comments::where('id',$id)->delete();
         return response()->json([
            'message' => 'Comment delete successfully',
            'status' => 200,
        ], 201);
    }
}
