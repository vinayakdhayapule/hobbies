<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;
use App\Models\Hobby;
use App\Models\UserHobby;
use Datatables;

class UserController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
	    if(request()->ajax()) {
			$users = Users::select(['id', 'firstname','lastname','created_at'])->get();

			return datatables()->of($users)
				->addColumn('hobbies', function ($user) {
					return $user->hobbies->pluck('name')->implode(', ');
				})
				->addColumn('created_at', function ($user) {
					return $user->created_at->format('Y-m-d H:i:s');
				})
				->addColumn('action', 'user-action')
				->rawColumns(['action'])
				->addIndexColumn()
				->make(true);
	    }
		
		$hobbies = Hobby::all();
		return view('user', compact('hobbies'));
	}
	 
	 
	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{  
	    $userid = $request->id;
	    $user   =   Users::updateOrCreate(['id' => $userid ],
	                ['firstname' => $request->firstname,'lastname' => $request->lastname,]);

		if(!is_null($userid)){
			UserHobby::where('users_id',$userid)->delete();
		}
		$user->hobbies()->attach($request->input('hobbies'));              
	    return Response()->json($user);

	}
	 
	 
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Users  $Users
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Request $request)
	{   
		
	    $where = array('id' => $request->id);
	    $company  = Users::where($where)->first();
	 
	    return Response()->json($company);
	}
	 
	 
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Users  $Users
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Request $request)
	{
		$users = Users::find($request->id);

		if (!$users) {
			return response()->json(['message' => 'Users not found'], 404);
		}

		// Soft delete the company
		$users->delete();
		return response()->json(['message' => 'Users deleted successfully']);
	}
}
