<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class SliderController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.slider.index');
    }

    /**
     * @param Request $request
     * @return array
     */
    public function store(Request $request)
    {
        $image = time()*rand(111, 999).'.'.$request->file('image')->getClientOriginalExtension();
        $request->image->storeAs('/', $image, 'slider');
        Slider::create(['title' => $request->title, 'image' => $image, 'status' => $request->status ? 1 : 0]);
        return ['status' => true, 'message' => 'Image saved successfully.'];
    }

    /**
     * @return mixed
     * @throws \Exception
     * Get slider data.
     */
    public function sliderList()
    {
        return DataTables::of(Slider::query())->addColumn('action', function($slider) {
            return '<a class="remove deleteRecord" href="javascript:void(0)" id="'.$slider->id.'" title="Remove"><i class="fas fa-trash"></i></a>';
        })->make(true);
    }

    /**
     * @param $id
     * @return array
     * Delete slider image.
     */
    public function destroy($id)
    {
        $slider = Slider::find($id);

        if ($slider) {
            Storage::disk('slider')->delete($slider->image);
            $slider->delete();
            return ['status' => true, 'message' => 'Record deleted successfully'];
        }

        return ['status' => false, 'message' => 'Record not found!'];
    }

    /**
     * @param Request $request
     * @return array
     * Change slider status.
     */
    public function changeSliderStatus(Request $request)
    {
        Slider::whereId($request->id)->update(['status' => $request->status]);
        return ['status' => true, 'message' => 'Status changed successfully.'];
    }
}
