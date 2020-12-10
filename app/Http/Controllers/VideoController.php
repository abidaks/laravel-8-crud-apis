<?php

namespace App\Http\Controllers;

use App\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

use File;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $videos = Video::all();
        return view('videos.index', ['videos' => $videos]);
    }

        /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function upload()
    {
        return view('videos.upload', ['errors' => false]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'title'=>'required',
            'video'=>'required|mimes:avi,mp4|max:200000'
        ];

        $response = array('response' => '', 'success'=> false);
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return view('videos.upload', ['errors' => $validator->messages()]);
        }else{

            $title = $request->get('title');
            $file = $request->file('video');

            $file_name = rand()."-".str_replace(" ", "-", strtolower($title)).".o.".$file->getClientOriginalExtension();
            $file_name3 = rand()."-".str_replace(" ", "-", strtolower($title)).".360p.".$file->getClientOriginalExtension();
            $file_name7 = rand()."-".str_replace(" ", "-", strtolower($title)).".720p.".$file->getClientOriginalExtension();
            $file_name10 = rand()."-".str_replace(" ", "-", strtolower($title)).".1080p.".$file->getClientOriginalExtension();
            //Move Uploaded File
            $destinationPath = 'uploads';
            $file->move($destinationPath, $file_name);

            File::copy($destinationPath."/".$file_name, $destinationPath."/".$file_name3);
            File::copy($destinationPath."/".$file_name, $destinationPath."/".$file_name7);
            File::copy($destinationPath."/".$file_name, $destinationPath."/".$file_name10);

            $video = new Video([
                'title' => $request->get('title'),
                'video' => $file_name3
            ]);

            $video->save();

            return Redirect::action('VideoController@view', array($video->id));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function view($id)
    {
        $video = Video::find($id);
        return view('videos.view', ['video' => $video]);
    }
}
