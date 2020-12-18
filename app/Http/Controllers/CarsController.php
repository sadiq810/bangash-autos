<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class CarsController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Load cars brands view.
     */
    public function index()
    {
        return view('admin.cars.index');
    }

    /**
     * @return mixed
     * @throws \Exception
     * Load brands to dataTables.
     */
    public function loadBrands()
    {
        $brands = Car::where('parent', 0)->withCount('models');

        return DataTables::of($brands)->addColumn('action', function ($brand) {
            return '<a href="javascript: void(0)" data-id="'.$brand->id.'" data-json=\''. json_encode($brand->only('title')) .'\' class="remove editRecord" title="Edit"><i class="fas fa-edit"></i></a>
                    |&nbsp;<a class="remove deleteRecord" href="javascript:void(0)" id="'.$brand->id.'" title="Remove"><i class="fas fa-trash"></i></a>';
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

        $data = $request->only(['title']);

        if ($request->has('parent'))
            $data['parent'] = $request->parent;

        Car::create($data);

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

        $data = $request->only(['title']);

        Car::whereId($id)->update($data);
        return ['status' => true, 'message' => 'Record updated successfully.'];
    }

    /**
     * @param $id
     * @return array
     * Delete record.
     */
    public function destroy($id)
    {
        Car::destroy($id);
        return ['status' => true, 'message' => 'Record deleted successfully.'];
    }

    /**
     * @return mixed
     * @throws \Exception
     * Load cars models.
     */
    public function loadModels()
    {
        return DataTables::of(Car::where('parent', request()->_id))->addColumn('action', function($models){
            return '<a href="javascript: void(0)" data-id="'.$models->id.'" data-parent="'.$models->parent.'" data-json=\''. json_encode($models->only('title')) .'\' class="remove editSubRecord" title="Edit"><i class="fas fa-edit"></i></a>
                    |&nbsp;<a class="remove deleteSubRecord" href="javascript:void(0)" data-parent="'.$models->parent.'"  id="'.$models->id.'" title="Remove"><i class="fas fa-trash"></i></a>';
        })->make(true);
    }
}
