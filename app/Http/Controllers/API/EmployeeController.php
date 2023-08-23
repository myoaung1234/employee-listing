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
        $employees = Employee::all();
        return response()->json([
            'success' => 'true',
            'message' => 'Employees retrieved successfully',
            'data' => $employees,
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
            'message' => 'Employee created successfully',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $employee = Employee::where(["id" => $id])->get();

        return response()->json([
            'success' => true,
            'message' => 'Employee retrieved successfully',
            'data' => $employee,
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

        $form_data = $request->all();
        $result = Employee::where(["id" => $id])->update($form_data);

        return response()->json([
            'success' => $result ? true : false,
            'message' => $result ? 'Employee updated successfully' : 'Employee update failure !!',
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
            'message' => $result ? 'Employee deleted successfully' : "Employee deleted failure !!",
        ]);
    }
}