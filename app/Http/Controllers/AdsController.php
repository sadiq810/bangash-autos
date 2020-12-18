<?php

namespace App\Http\Controllers;

use App\Models\Ads;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class AdsController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.ads.index');
    }

    /**
     * @param Request $request
     * @return array
     */
    public function store(Request $request)
    {
        $image = time()*rand(111, 999).'.'.$request->file('image')->getClientOriginalExtension();
        $request->image->storeAs('/', $image, 'ads');
        Ads::create(['title' => $request->title, 'url' => $request->url, 'image' => $image, 'status' => $request->status ? 1 : 0]);
        return ['status' => true, 'message' => 'Record saved successfully.'];
    }

    /**
     * @return mixed
     * @throws \Exception
     * Get Ads data.
     */
    public function adsList()
    {
        return DataTables::of(Ads::query())->addColumn('action', function($ads) {
            return '<a class="remove deleteRecord" href="javascript:void(0)" id="'.$ads->id.'" title="Remove"><i class="fas fa-trash"></i></a>';
        })->make(true);
    }

    /**
     * @param $id
     * @return array
     * Delete Ads image.
     */
    public function destroy($id)
    {
        $ads = Ads::find($id);

        if ($ads) {
            Storage::disk('ads')->delete($ads->image);
            $ads->delete();
            return ['status' => true, 'message' => 'Record deleted successfully'];
        }

        return ['status' => false, 'message' => 'Record not found!'];
    }

    /**
     * @param Request $request
     * @return array
     * Change Ads status.
     */
    public function changeAdsStatus(Request $request)
    {
        Ads::whereId($request->id)->update(['status' => $request->status]);
        return ['status' => true, 'message' => 'Status changed successfully.'];
    }
}
