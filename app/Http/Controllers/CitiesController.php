<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class CitiesController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Load cars brands view.
     */
    public function index()
    {
        return view('admin.cities.index');
    }

    /**
     * @return mixed
     * @throws \Exception
     * Load cities to dataTables.
     */
    public function loadCities()
    {
        $cities = City::query();

        return DataTables::of($cities)->addColumn('action', function ($city) {
            return '<a href="javascript: void(0)" data-id="'.$city->id.'" data-json=\''. json_encode($city->only('title')) .'\' class="remove editRecord" title="Edit"><i class="fas fa-edit"></i></a>
                    |&nbsp;<a class="remove deleteRecord" href="javascript:void(0)" id="'.$city->id.'" title="Remove"><i class="fas fa-trash"></i></a>';
        })->make(true);
    }

    /**
     * @param Request $request
     * @return array
     * Create new one.
     */
    public function create(Request $request)
    {
        if ($request->has('id') and $request->id)
            return $this->update($request, $request->id);

        $validator = Validator::make($request->all(), [
            'title' => 'required'
        ]);

        if ($validator->fails())
            return ['status' => false, 'validationError' => implode(' ', $validator->getMessageBag()->all())];

        City::create($request->only(['title']));

        return ['status' => true, 'message' => 'Record saved successfully.'];
    }

    /**
     * @param $request
     * @param $id
     * @return array
     * Update a record.
     */
    private function update($request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required'
        ]);

        if ($validator->fails())
            return ['status' => false, 'validationError' => implode(' ', $validator->getMessageBag()->all())];

        City::whereId($id)->update($request->only(['title']));
        return ['status' => true, 'message' => 'Record updated successfully.'];
    }

    /**
     * @param $id
     * @return array
     * Delete record.
     */
    public function destroy($id)
    {
        City::destroy($id);
        return ['status' => true, 'message' => 'Record deleted successfully.'];
    }
}
