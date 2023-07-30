<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Teacher;


class TeacherController extends Controller
{
    public function index(){
        $teachers = Teacher::all();
        if($teachers->count() > 0){
            return response()->json([
                'status' => true,
                'teachers' => $teachers
            ], 200);
        }

        return response()->json([
                  'status' => false,
                  'message' => 'No teacher found'
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
            $teacher = new Teacher();
            $teacher->name = $request->name;
            $teacher->email = $request->email;
            $teacher->phone = $request->phone;
            $teacher->course = $request->course;
            $teacher->save();

            return response()->json([
              'status' => true,
              'message' => 'Teacher added successfully',
              'teacher' => $teacher
            ], 201);
        }
    }

    public function show($id){
        $teacher = Teacher::find($id);
        if($teacher){
            return response()->json([
              'status' => true,
              'teacher' => $teacher
            ], 200);
        }else {
            return response()->json([
                         'status' => false,
                         'message' => 'Teacher not found'
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
            $teacher = Teacher::find($id);
            $teacher->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'course' => $request->course
            ]);

            if($teacher){
                return response()->json([
                                 'status' => true,
                                'message' => 'Teacher updated successfully',
                                'teacher' => $teacher
                                ], 200);
            }else {
                return response()->json([
                        'status' => false,
                        'message' => 'Teacher not found'
                        ], 404);
            }
        }

    }

    public function destroy($id){
        $teacher = Teacher::find($id);
        if($teacher){
            $teacher->delete();
            return response()->json([
               'status' => true,
              'message' => 'Teacher deleted successfully'
            ], 200);
        }else {
            return response()->json([
                        'status' => false,
                        'message' => 'Teacher not found'
                        ], 404);
        }
    }
}
