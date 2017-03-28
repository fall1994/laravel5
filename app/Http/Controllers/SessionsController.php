<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Auth;

class SessionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest', [
                'only' => ['create', 'signup']
            ]);
    }
	/**
	 * 用户登录
	 * @return [type] [description]
	 */
    public function create()
    {
    	return view('sessions.create');
    }
    /**
     * 登录验证
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function store(Request $request)
    {
    	$this->validate($request, [
    			'email' => 'required|email|max:255',
    			'password' => 'required'
    		]);

    	$credentials = [
    		'email' => $request->email, 
    		'password'=>$request->password,
    	];
    	if(Auth::attempt($credentials, $request->has('remember'))) {
    		session()->flash('success', '欢迎回来！');
        	return redirect()->intended(route('users.show', [Auth::user()]));
    	} else {
    		session()->flash('danger', '很抱歉，您的邮箱和密码不匹配');
    		return redirect()->back();
    	}
    	session()->flash('success', '欢迎，您将在这里开启一段新的旅程！');
    	return redirect()->route('users.show', [$user]);
    }
    /**
     * 注销登录，删除会话
     * @return [type] [description]
     */
    public function destroy()
    {
    	Auth::logout();
    	session()->flash('success', '您已成功退出！');
    	return redirect('login');
    }
}
