<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;

class UsersController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth', [
			'only' => ['edit', 'update', 'destroy']
		]);
		$this->middleware('guest', [
            'only' => ['create']
        ]);
	}

	public function index()
	{
		$users = User::paginate(5);
		return view('users.index', compact('users'));
	}

    public function create()
    {
    	return view('users.create');
    }

    public function show($id)
    {
    	$user = User::findOrFail($id);
    	$statuses = $user->statuses()
    					 ->orderBy('created_at', 'desc')
    					 ->paginate(5);
    	return view('users.show', compact('user', 'statuses'));
    }

    public function store(Request $request)
    {
    	$this->validate($request, [
    			'name'=>'required|max:50',
    			'email'=>'required|email|unique:users|max:255',
    			'password'=>'required|confirmed'
    		]);
    	$user = User::create([
    			'name'=>$request->name,
    			'email'=>$request->email,
    			'password'=>bcrypt($request->password),
    		]);
    	Auth::login($user);
    	session()->flash('success', '欢迎，您将在这里开启一段新的旅程~');
    	return redirect()->route('users.show', [$user]);
    }

    public function edit($id)
    {
    	$user = User::findOrFail($id);
    	$this->authorize('update', $user);
    	// echo($user);
    	return view('users.edit', compact('user'));
    }

    public function update($id, Request $request)
    {
    	$this->validate($request, [
    			'name' => 'required|max:50',
    			'password' => 'confirmed|min:6',
    		]);

    	$user = User::findOrFail($id);
    	$this->authorize('update', $user);
    	$data = [];
    	$data['name'] = $request->name;
    	if($request->password) {
    		$data['password'] = bcrypt($request->password);
    	}
    	$user->update($data);
    	session()->flash('success', '更新个人资料成功！');
    	return redirect()->route('users.show', $id);
    }

    public function destroy($id)
    {
    	$user = User::findOrFail($id);
    	$this->authorize('destroy', $user);
    	$user->delete();
    	session()->flash('success', '成功删除用户！');
    	return back();
    }

    public function followings($id)
    {
    	$user = User::findOrFail($id);
    	$users = $user->followings()->paginate(5);
    	$title = '关注的人';
    	return view('users.show_follow', compact('users', 'title'));
    }

    public function followers($id)
    {
        $user = User::findOrFail($id);
        $users = $user->followers()->paginate(30);
        $title = '粉丝';
        return view('users.show_follow', compact('users', 'title'));
    }

    public function test()
    {
        echo __NAMESPACE__;
    }
}
