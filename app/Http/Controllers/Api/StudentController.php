<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function index(){
        $students = Student::all();
        if($students->count() > 0){
            return response()->json([
                'status' => true,
                'students' => $students
            ], 200);
        }

        return response()->json([
                  'status' => false,
                  'message' => 'No student found'
                ], 404);
        
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' =>'required|max:191|string',
            'email' =>'required|email',
            'phone' =>'required|digits:12',
            'course' =>'required|string',
        ]);

        if($validator->fails()){
            return response()->json([
                          'status' => false,
                          'message' => $validator->messages()
                        ], 422);
        }else {
            $student = new Student();
            $student->name = $request->name;
            $student->email = $request->email;
            $student->phone = $request->phone;
            $student->course = $request->course;
            $student->save();

            return response()->json([
              'status' => true,
              'message' => 'Student added successfully',
              'student' => $student
            ], 201);
        }
    }

    public function show($id){
        $student = Student::find($id);
        if($student){
            return response()->json([
              'status' => true,
              'student' => $student
            ], 200);
        }else {
            return response()->json([
                         'status' => false,
                         'message' => 'Student not found'
                        ], 404);
        }
    }    

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'name' =>'required|max:191|string',
            'email' =>'required|email',
            'phone' =>'required|digits:12',
            'course' =>'required|string',
        ]);

        if($validator->fails()){
            return response()->json([
                          'status' => false,
                          'message' => $validator->messages()
                        ], 422);
        }else {
            $student = Student::find($id);
            $student->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'course' => $request->course
            ]);

            if($student){
                return response()->json([
                                 'status' => true,
                                'message' => 'Student updated successfully',
                                'student' => $student
                                ], 200);
            }else {
                return response()->json([
                        'status' => false,
                        'message' => 'Student not found'
                        ], 404);
            }
        }

    }

    public function destroy($id){
        $student = Student::find($id);
        if($student){
            $student->delete();
            return response()->json([
               'status' => true,
              'message' => 'Student deleted successfully'
            ], 200);
        }else {
            return response()->json([
                        'status' => false,
                        'message' => 'Student not found'
                        ], 404);
        }
    }
}
