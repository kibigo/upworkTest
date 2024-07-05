<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use Illuminate\Http\Request;

class SubmitController extends Controller
{
    public function test()
    {
        return response()->json("Working well");
    }
    public function insert(Request $request)
    {
        try {
            request()->validate([
                'name' => 'required|min:5|max:255',
                'email' => 'required|email|unique:submissions,email',
                'message' => 'required'
            ]);
    
    
            $post = new Submission;
    
            $post->name = trim($request->name);
            $post->email = trim($request->email);
            $post->message = trim($request->message);
    
            $post->save();
    
            return response()->json([
                'message' => 'Submission Saved',
                'name' => $post->name,
                'email' => $post->email
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'errors' => $e->errors()
            ], 422);
        } 
        // catch (\Exception $e){
        //     return response()->json(['error' => 'Failed to save submission'], 500);
        // }
    }
}
