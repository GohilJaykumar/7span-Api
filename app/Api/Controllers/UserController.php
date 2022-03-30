<?php

namespace App\Api\Controllers;

use App\Models\User;
use App\Models\Hobby;
use App\Models\UserHobby;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use JWTAuth;
use Illuminate\Support\Facades\Hash;
use Auth;
use App\Api\Requests\User\AddRequest as AddUserRequest;
use App\Api\Requests\UserHobby\AddRequest as AddUserHobbyRequest;

class UserController extends Controller
{
	/*Created success()/error() response serviceProvide for resuabilty of code for mobile REST api*/
	public function authenticate(Request $request)
	{
		$credentials = $request->only('email', 'password');
		try {
			if (! $token = JWTAuth::attempt($credentials)) {
				return response()->error([
					'message'        => 'Invalid credentials' ,
				]);
			}
		} catch (JWTException $e) {
			return response()->error([
				'message'        => 'could not create token' ,
			]);
		}

		return response()->success([
			'message' => 'Login Successfully',
			'data' => Auth::user(),
			'token' => $token,
		]);
	}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$userList = User::all();

    	return response()->success([
    		'data' => $userList,
    	]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddUserRequest $request)
    {
    	$user = new User;

    	/*loops is useful when we are dealing with large number of field creation/updation. This logic will work for both Create/Update scenairo's.*/
    	$fields = ['first_name', 'last_name', 'email', 'password', 'phone', 'status'];
    	foreach ($fields as $key => $field) {
    		if ($request->exists($field)) {
    			switch ($field) {
    				default:
    				if ($field == 'password') {
    					$user->$field = Hash::make($request->$field);
    				} else {
    					$user->$field = $request->$field;
    				}
    				break;
    			}
    		}
    	}

    	if ($request->hasfile('photo')) {
    		$file = $request->photo;
    		$name = time() . '-' . md5(time()) . '-' . $file->getClientOriginalName();
    		$file->storeAs('/uploads/user/photo/', $name, 'public');
    		$user->photo = '/uploads/user/photo/' . $name;
    	} 
    	
    	$user->save();

    	return response()->success([
    		'message' => 'User Created Successfully',
    		'data' => $user,
    	]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    	$userDetail = User::find($id);

    	if ($userDetail) {
    		return response()->success([
    			'data' => $userDetail,
    		]);
    	} else {
    		return response()->error([
    			'message'        => 'Invalid User Details' ,
    		]);
    	}

    }

    public function profile()
    {
    	$userDetail = Auth::user();
    	return response()->success([
    		'data' => $userDetail,
    	]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
    	$user = Auth::user();

    	$validatedData = $request->validate([
    		'first_name'        => 'string|max:55',
    		'last_name'        => 'string|max:55',
    		'email'       => 'string|email|max:100|unique:users,email,' . $user->id.',id',
    		'photo'    => 'mimes:jpeg,png',
    		'phone'    => 'digits:10',
    		'status'    => 'in:Active,Deactive',
    	]);

    	/*loops is useful when we are dealing with large number of field creation/updation. This logic will work for both Create/Update scenairo's.*/
    	$fields = ['first_name', 'last_name', 'email', 'phone', 'status'];
    	foreach ($fields as $key => $field) {
    		if ($request->exists($field)) {
    			switch ($field) {
    				default:
    				$user->$field = $request->$field;
    				break;
    			}
    		}
    	}

    	if ($request->hasfile('photo')) {
    		$file = $request->photo;
    		$name = time() . '-' . md5(time()) . '-' . $file->getClientOriginalName();
    		$file->storeAs('/uploads/user/photo/', $name, 'public');
    		$user->photo = '/uploads/user/photo/' . $name;
    	} 
    	
    	$user->save();

    	return response()->success([
    		'message' => 'User Updated Successfully',
    		'data' => $user,
    	]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    	$userList = User::find($id); 

    	if ($userList) {
    		$userList->delete();
    		return response()->sucsessMessage([
    			'message' => "User Deleted Successfully",
    		]);
    	} else {
    		return response()->error([
    			'message'        => 'User Not Found',
    		]);
    	}

    }

    public function getUserHobby()
    {
    	$userHobby = UserHobby::with('hobby')->where('user_id',Auth::id())->get(); 
    	return response()->success([
    		'data' => $userHobby,
    	]);
    }

    public function addUserHobby(AddUserHobbyRequest $request)
    {
    	$userHobby = UserHobby::with('hobby')->updateOrCreate([
    		'user_id' => Auth::id(),
    		'hobby_id' => $request->hobby_id,
    	]); 
    	return response()->success([
    		'message' => 'Hobby added successfully',
    		'data' => $userHobby,
    	]);
    }

    public function deleteUserHobby($id)
    {
    	$userHobby = UserHobby::where('user_id',Auth::id())->find($id); 

    	if ($userHobby) {
    		$userHobby->delete();
    		return response()->sucsessMessage([
    			'message' => "User Hobby Deleted Successfully",
    		]);
    	} else {
    		return response()->error([
    			'message'        => 'User Hobby Not Found',
    		]);
    	}
    }
}