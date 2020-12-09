<?php

namespace App\Http\Controllers;
use App\Classes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class ClassController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request)
    {
        $classes = Classes::all();
        //foreach ($classes as $key => $class){
        //    $class->students;
        //}
        $response = array('response' => ["message"=> "", "data"=> $classes], 'success'=> true);
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
            'code'=>'required|alpha',
            'name'=>'required',
            'status'=>'required|in:opened,closed',
            'maximum_students'=>'required|numeric|max:10'
        ];

        $response = array('response' => '', 'success'=> false);
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $response['response'] = $validator->messages();
        }else{
            $class = new Classes([
                'code' => $request->get('code'),
                'name' => $request->get('name'),
                'status' => $request->get('status'),
                'description' => $request->get('description'),
                'maximum_students' => $request->get('maximum_students')
            ]);

            $class->save();
            $response['response'] = ["message"=> "The class has been created successfully", "data"=>$class];
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
        $existingClass = Classes::find($id);
        if (!$existingClass instanceof Classes) {
            $response['response'] = 'The class cannot be found.';
            return Response::json($response, 200);
        }
        $existingClass->students;
        $response['response'] = ["message"=> "", "data"=> $existingClass];
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
            'code'=>'required|alpha',
            'name'=>'required',
            'status'=>'required|in:opened,closed',
            'maximum_students'=>'required|numeric|max:10'
        ];

        $response = array('response' => '', 'success'=> false);
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $response['response'] = $validator->messages();
        }else{
            $existingClass = Classes::find($id);
            if (!$existingClass instanceof Classes) {
                $response['response'] = 'The class cannot be found.';
                return Response::json($response, 200);
            }

            $updatedClass = $existingClass->update($request->all());
            $response['response'] = ["message"=> "The class has been updated successfully", "data"=>$existingClass];
            $response['success'] = true;
        }
        return Response::json($response, 200);
    }
}
