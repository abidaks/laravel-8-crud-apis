<?php

namespace App\Http\Controllers;

use App\Classes;
use App\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function list()
    {
        $students = Student::all();
        //foreach ($students as $key => $student){
        //    $dob = explode("-", $student['date_of_birth']);
        //    $students[$key]['date_of_birth'] = ['year' => $dob[0], 'month' => $dob[1], 'day' => $dob[2]];
        //}
        $response = array('response' => ["message"=> "", "data"=> $students], 'success'=> true);
        return Response::json($response, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function add(Request $request)
    {
        $rules = [
            'first_name'=>'required',
            'last_name'=>'required',
            'classes_id'=>'required|numeric'
        ];

        $response = array('response' => '', 'success'=> false);
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $response['response'] = $validator->messages();
        }else{
            $existingClass = Classes::find($request->get('classes_id'));
            if (!$existingClass instanceof Classes) {
                $response['response'] = ['error' => 'The class cannot be found.'];
                return Response::json($response, 200);
            }
            $students = $existingClass->students;

            if($students->count() >= $existingClass->maximum_students){
                $response['response'] = ['error' => 'The student cannot be added to this class. It already has maximum students allowed.'];
                return Response::json($response, 200);
            }

            $date_of_birth = $request->get('date_of_birth');
            $dtcheck = checkdate($date_of_birth['month'], $date_of_birth['day'], $date_of_birth['year']);
            if(!$dtcheck){
                $response['response'] = ['date_of_birth' => 'The selected date of birth is not correct.'];
                return Response::json($response, 200);
            }
            
            $dob = $date_of_birth['year']."-".$date_of_birth['month']."-".$date_of_birth['day'];
            $student = new Student([
                'first_name' => $request->get('first_name'),
                'last_name' => $request->get('last_name'),
                'date_of_birth' => $dob,
                'classes_id' => $request->get('classes_id')
            ]);

            $student->save();
            $response['response'] = ["message" => "The student has been created successfully", "data"=>$student];
            $response['success'] = true;
        }
        return Response::json($response, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function view($id)
    {
        $response = array('response' => '', 'success'=> false);
        $existingStudent = Student::find($id);
        if (!$existingStudent instanceof Student) {
            $response['response'] = 'The student cannot be found.';
            return Response::json($response, 200);
        }
        
        $dob = explode("-", $existingStudent['date_of_birth']);
        $existingStudent['date_of_birth'] = ['year' => intval($dob[0]), 'month' => intval($dob[1]), 'day' => intval($dob[2])];
        
        $classes = Classes::all();
        $response['response'] = ["message"=> "", "data"=> $existingStudent, 'classes' => $classes];
        $response['success'] = true;

        return Response::json($response, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Request $request, $id)
    {
        $rules = [
            'first_name'=>'required',
            'last_name'=>'required',
            'classes_id'=>'required|numeric'
        ];

        $response = array('response' => '', 'success'=> false);
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $response['response'] = $validator->messages();
        }else{
            $existingClass = Classes::find($request->get('classes_id'));
            if (!$existingClass instanceof Classes) {
                $response['response'] = ['error' => 'The class cannot be found.'];
                return Response::json($response, 200);
            }

            $existingStudent = Student::find($id);
            if (!$existingStudent instanceof Student) {
                $response['response'] = ['error' => 'The student cannot be found.'];
                return Response::json($response, 200);
            }
            if($existingStudent->classes_id != $request->get('classes_id')){
                $students = $existingClass->students;
                if($students->count() >= $existingClass->maximum_students){
                    $response['response'] = ['error' => 'The student cannot be added to this class. It already has maximum students allowed.'];
                    return Response::json($response, 200);
                }
            }

            $date_of_birth = $request->get('date_of_birth');
            $dtcheck = checkdate($date_of_birth['month'], $date_of_birth['day'], $date_of_birth['year']);
            if(!$dtcheck){
                $response['response'] = ['date_of_birth' => 'The selected date of birth is not correct.'];
                return Response::json($response, 200);
            }
            
            $dob = $date_of_birth['year']."-".$date_of_birth['month']."-".$date_of_birth['day'];
            $updatedStudent = $existingStudent->update([
                        'first_name' => $request->get('first_name'),
                        'last_name' => $request->get('last_name'),
                        'date_of_birth' => $dob,
                        'classes_id' => $request->get('classes_id')
                    ]);
            
            $response['response'] = ["message"=> "The student has been updated successfully", "data"=>$updatedStudent];
            $response['success'] = true;
        }
        return Response::json($response, 201);
    }
}
