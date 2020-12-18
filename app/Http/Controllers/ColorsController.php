<?php

namespace App\Http\Controllers;

use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class ColorsController extends Controller
{
    /**
     * Load color view.
     */
    public function index()
    {
        return view('admin.color.index');
    }//..... end of index() .....//

    /**
     * @return mixed
     * @throws \Exception
     * List colors for dataTables.
     */
    public function colorsList()
    {
        return DataTables::of(Color::query())->addColumn('action', function ($color) {
            return '<a href="javascript: void(0)" data-id="'.$color->id.'" data-json=\''. json_encode($color->only(['title', 'color'])) .'\' class="remove editRecord" title="Edit"><i class="fas fa-edit"></i></a>
                    |&nbsp;<a class="remove deleteRecord" href="javascript:void(0)" id="'.$color->id.'" title="Remove"><i class="fas fa-trash"></i></a>';
        })->make(true);
    }//..... end of colorsList() .....//

    /**
     * @param Request $request
     * @return array
     * Create new one.
     */
    public function save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required'
        ]);

        if ($validator->fails())
            return ['status' => false, 'validationError' => implode(' ', $validator->getMessageBag()->all())];

        if ($request->has('id') and $request->id)
            Color::whereId($request->id)->update($request->only(['title', 'color']));
        else
            Color::create($request->only(['title', 'color']));

        return ['status' => true, 'message' => 'Record saved successfully.'];
    }

    /**
     * @param $id
     * @return array
     * Delete record.
     */
    public function destroy($id)
    {
        Color::destroy($id);
        return ['status' => true, 'message' => 'Record deleted successfully.'];
    }
}
