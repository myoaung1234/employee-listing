<?php

namespace App\Http\Controllers\API;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $limit = $request->get('limit') ? (int) $request->get('limit') : 10;
        $offset = $request->get('offset') ? (int) $request->get('offset') : 0;

        $posts = Employee::with('author');
        $postCount = $posts->count();
        $posts = $posts->offset($offset)->limit($limit)->get();

        return response()->json([
            'success' => 'true',
            'message' => 'Data retrieved successfully',
            'data' => $posts,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'address' => 'required',
            'company' => 'required',
            'position' => 'required'

        ]);

        if( $validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 400);
        }

        $form_data = $request->all();

        Employee::create($form_data);

        return response()->json([
            'success' => 'true',
            'message' => 'Data saved successfully',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $jobpost = Employee::where("id",$id)->get();

        return response()->json([
            'success' => 'true',
            'message' => 'Data retrieved successfully',
            'data' => $jobpost,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'address' => 'required',
            'company' => 'required',
            'position' => 'required'
        ]);

        if( $validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 400);
        }

        $form_data = $request->only('name', 'address', 'phone', 'company', 'position', 'salary');
        $result = Employee::where(["id" => $id])->update($form_data);

        return response()->json([
            'success' => $result ? true : false,
            'message' => $result ? 'Data updated successfully' : 'Data update failure !!',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result = Employee::destroy($id);

        return response()->json([
            'success' => $result ? true : false,
            'message' => $result ? 'Data deleted successfully' : "Data deleted failure !!",
        ]);
    }
}