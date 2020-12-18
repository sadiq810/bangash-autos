<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Promotion;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PromotionsController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Load index view of promotions.
     */
    public function index()
    {
        return view('admin.promotions.index');
    }//..... end index() .....//

    /**
     * @return mixed
     * @throws \Exception
     * Load promotions list for dataTables.
     */
    public function promotionsList()
    {
        return DataTables::of(Promotion::query())->addColumn('action', function($promotion) {
            return '<a class="remove deleteRecord" href="javascript:void(0)" id="'.$promotion->id.'" title="Remove"><i class="fas fa-trash"></i></a> |
                    <a class="remove" href="'.route('promotion.edit', $promotion->id). '" title="Edit"><i class="fas fa-edit"></i></a>';
        })->make(true);
    }//...... end of promotionsList() .....//

    /**
     * @param Request $request
     * @return array
     * Change promotion status.
     */
    public function changePromotionStatus(Request $request)
    {
        Promotion::whereId($request->id)->update(['status' => $request->status]);
        return ['status' => true, 'message' => 'Status changed successfully.'];
    }//..... end of changePromotionStatus() .....//

    /**
     * @param $id
     * @return array
     * Delete Promotion.
     */
    public function destroy($id)
    {
        Promotion::destroy($id);
        return ['status' => false, 'message' => 'Record deleted successfully'];
    }//..... end of destroy() .....//

    /**
     * Create new resource.
     */
    public function create()
    {
        return view('admin.promotions.create', ['promotion' => new Promotion()/*, 'categories' => $this->getCategories()*/]);
    }//..... end of create() .....//

    /**
     * @return mixed
     * Get categories for dropDownList.
     */
    private function getCategories()
    {
        return Category::where('parent', 0)->pluck('title', 'id');
    }//..... end of getCategories() .....//

    /**
     * Save Promotion.
     */
    public function save(Request $request)
    {
        $data = $request->only(['title', /*'category_id',*/ 'trigger_amount', 'start_date', 'end_date', 'outcome']);
        $data['status'] = $request->status ? 1 : 0;
        $data['amount'] = $request->amount ?? 0;

        if ($request->id)
            Promotion::whereId($request->id)->update($data);
        else
            Promotion::create($data);

        return ['status' => true, 'message' => 'Record saved successfully.'];
    }//..... end of save() .....//

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Edit promotion.
     */
    public function edit($id)
    {
        return view('admin.promotions.create', ['promotion' => Promotion::findOrFail($id)/*, 'categories' => $this->getCategories()*/]);
    }//.... end edit() .....//
}
