<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Role;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.roles.index', ['menus' => Menu::all()]);
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

        Role::create($request->only(['title']));
        return ['status' => true, 'message' => 'Role created successfully.'];
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
        Role::whereId($id)->update($request->only(['title']));
        return ['status' => true, 'message' => 'Role updated successfully.'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Role::destroy($id);
        return ['status' => true, 'message' => 'Role deleted successfully.'];
    }

    /**
     * @return mixed
     * @throws \Exception
     * Load roles for dataTables.
     */
    public function rolesList()
    {
        return DataTables::of(Role::with('menus'))->addColumn('action', function($role){
            return '<a href="javascript: void(0)" data-id="'.$role->id.'" data-json=\''. json_encode($role->menus) .'\' class="remove assignMenus" title="Assign Menus"><i class="fas  fa-bars"></i></a>
                    |&nbsp;<a href="javascript: void(0)" data-json=\''. json_encode($role) .'\' class="remove editRecord" title="Edit"><i class="fas fa-edit"></i></a>
                    |&nbsp;<a class="remove deleteRecord" href="javascript:void(0)" id="'.$role->id.'" title="Remove"><i class="fas fa-trash"></i></a>';
        })->make(true);
    }

    /**
     * @param Request $request
     * @return array
     * Assign menu to role.
     */
    public function assignMenus(Request $request)
    {
        Role::find($request->id)->menus()->sync(array_values($request->menus));
        return ['status' => true, 'message' => 'Data saved successfully.'];
    }

    /**
     * @param int $role_id
     * @return mixed
     * Get role's menus.
     */
    public function getRoleMenus($role_id = 0)
    {
        return optional(Role::find($role_id))->menus;
    }
}
