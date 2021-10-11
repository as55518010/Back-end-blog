<?php

namespace App\Http\Controllers;

use App\Models\BlogInfo;
use Illuminate\Http\Request;

class BlogInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'result' => BlogInfo::with(['user' => function ($user) {
                return $user->with('detail');
            }])->get()
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return response()->json([
            'result' => BlogInfo::create($request->only(['user_id', 'blog_bottom_narrate', 'blog_theme_style', 'blog_big_back_img', 'blog_create_time']))
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BlogInfo  $blogInfo
     * @return \Illuminate\Http\Response
     */
    public function show(BlogInfo $info)
    {
        return response()->json([
            'result' => $info->load(['user' => function ($user) {
                return $user->with('detail');
            }])
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BlogInfo  $blogInfo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BlogInfo $info)
    {

        $info->update($request->only(['blog_bottom_narrate','blog_theme_style','blog_big_back_img','blog_create_time']));
        return response()->json(['message' => '個人專區更新成功', 'result' => $info], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BlogInfo  $blogInfo
     * @return \Illuminate\Http\Response
     */
    public function destroy(BlogInfo $info)
    {
        //
    }
}
