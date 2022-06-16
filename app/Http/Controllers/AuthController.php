<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Validator;
use DB;

class AuthController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if (! $token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->createNewToken($token);
    }
    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|confirmed|min:6',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        $user = User::create(array_merge(
                    $validator->validated(),
                    ['password' => bcrypt($request->password)]
                ));
        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        auth()->logout();
        return response()->json(['message' => 'User successfully signed out']);
    }
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh() {
        return $this->createNewToken(auth()->refresh());
    }
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile() {
        return response()->json(auth()->user());
    }
    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }

    public function addcomment(Request $request) {
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
        $comments = Comments::find($id);
        $comments->comment  = $request->comment;
        $comments->update();

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
