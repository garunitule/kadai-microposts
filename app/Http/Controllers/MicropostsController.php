<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MicropostsController extends Controller
{
    public function index() {
        $data = [];
        if(\Auth::check()) {
            $user = \Auth::user();
            $microposts = $user->feed_microposts()->orderBy('created_at', 'desc')->paginate(10);
            
            $data = [
                  'user' => $user,
                  'microposts' => $microposts
                ];
        }
        
        return view('welcome', $data);
    }
    
    public function store(Request $request) {
        $this->validate($request, [
                'content'=>'required|max:191'
            ]);
            
        $request->user()->microposts()->create([
                'content' => $request->content,
            ]);
            
        //dd($request);
            
        return back();
    }
    
    public function destroy($id) {
        $micropost = \App\Micropost::find($id);

        if (\Auth::id() === $micropost->user_id) {
            //現在ログインしているユーザーのIDと投稿に付随したユーザーIDが一致している時のみ削除する
            
            $micropost->delete();
        }

        return back();
    }
}
