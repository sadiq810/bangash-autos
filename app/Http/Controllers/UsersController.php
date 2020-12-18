<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.users.index', ['roles' => Role::pluck('title', 'id')]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->has('id') and $request->id)
            return $this->update($request, $request->id);

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
        ]);

        if ($validator->fails())
            return ['status' => false, 'validationError' => implode(' ',$validator->getMessageBag()->all()), 'message' => 'Please provide valid information'];

        User::create(array_merge(['password' => bcrypt($request->password)], $request->only(['name', 'email', 'role_id'])));
        return ['status' => true, 'message' => 'User saved successfully.'];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'role_id' => 'required',
            'password' => 'nullable|min:6'
        ]);

        if ($validator->fails())
            return ['status' => false, 'validationError' => implode(' ',$validator->getMessageBag()->all()), 'message' => 'Please provide valid information'];

        $data = $request->only(['name', 'email', 'role_id']);

        if ($request->has('password') and $request->password)
            $data['password'] = bcrypt($request->password);

        User::whereId($id)->update($data);
        return ['status' => true, 'message' => 'User updated successfully.'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::destroy($id);
        return ['status' => true, 'message' => 'User deleted successfully.'];
    }

    /**
     * @return mixed
     * @throws \Exception
     * Load users list.
     */
    public function usersList()
    {
        return DataTables::of(User::with('role'))->addColumn('action', function($user){
            return '<a href="javascript: void(0)" data-id="'.$user->id.'" data-json=\''. json_encode($user->only(['name', 'email', 'role_id'])) .'\' class="remove editRecord" title="Edit"><i class="fas fa-edit"></i></a>
                    |&nbsp;<a class="remove deleteRecord" href="javascript:void(0)" id="'.$user->id.'" title="Remove"><i class="fas fa-trash"></i></a>';
        })->make(true);
    }//..... end of usersList() .....//
}
