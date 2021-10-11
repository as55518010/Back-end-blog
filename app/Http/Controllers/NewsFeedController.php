<?php

namespace App\Http\Controllers;

use App\Models\NewsFeed;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NewsFeedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pagination = json_decode($request['pagination'], true);
        $where      = json_decode($request['where'], true);
        $order      = json_decode($request['order'], true);
        $query      = NewsFeed::with(['user' => function ($user) {
            return $user->with('detail');
        }]);

        if ($where) {
            foreach ($where as $key => $value) {
                $query->where(Str::snake($key), $value);
            }
        }
        if ($order) {
            foreach ($order as $key => $value) {
                if (Str::snake($key) === 'article_detils') {
                    foreach ($value as $key1 => $value1) {
                        $query->orderByWith('articleDetil', $key1, $value1);
                    }
                } else {
                    $query->orderBy(Str::snake($key), $value);
                }
            }
        }
        $res = $query->paginate($pagination['size'], ['*'], 'page', $pagination['page']);

        return response()->json([
            'list'      => $res->items(),
            'pagination' => [
                'page'  => $res->currentPage(),
                'size'  => $pagination['size'],
                'total' => $res->total(),
            ]
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
            'result' => NewsFeed::create(array_merge(['user_id'=>Auth::user()->id],$request->only(['title','content','image','place'])))
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\NewsFeed  $newsFeed
     * @return \Illuminate\Http\Response
     */
    public function show(NewsFeed $newsfeed)
    {
        return response()->json([
            'result' => $newsfeed->load(['user' => function ($user) {
                return $user->with('detail');
            }])
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\NewsFeed  $newsFeed
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NewsFeed $newsfeed)
    {
        $newsfeed->update($request->only(['title','content','image','place']));
        return response()->json(['message' => '個人專區更新成功', 'result' => $newsfeed], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\NewsFeed  $newsFeed
     * @return \Illuminate\Http\Response
     */
    public function destroy(NewsFeed $newsFeed)
    {
        //
    }
}
