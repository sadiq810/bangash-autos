<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Setting;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        \JavaScript::put(['categories' => Category::orderBy('order', 'asc')->whereStatus(1)->where('parent', 0)->with('subCategories')->get()]);
        \JavaScript::put($this->getSettings());
        \JavaScript::put((new PagesController())->getPages());
        \JavaScript::put(['saleCategoryBanner' => Setting::where(['type' => 'saleCategoryImage'])->value('value')]);
        \JavaScript::put(['shipCostMethod' => Setting::where(['type' => 'shipCostMethod'])->value('value')]);
        \JavaScript::put(['perKgCharges' => Setting::where(['type' => 'perKgCharges'])->value('value')]);

        if ($request->method() == 'GET') {
            return view('index');
        } else
            abort(404);
    }

    /**
     * @return array
     * Get various settings.
     */
    private function getSettings()
    {
        return [
            'phone' => optional(Setting::whereType('phone')->first())->value,
            'contactEmail' => optional(Setting::whereType('contactEmail')->first())->value,
            'officeAddress' => optional(Setting::whereType('officeAddress')->first())->value,
            'facebookPageUrl' => optional(Setting::whereType('facebookPageUrl')->first())->value,
            'twitterUrl' => optional(Setting::whereType('twitterUrl')->first())->value,
            'pinterestUrl' => optional(Setting::whereType('pinterestUrl')->first())->value,
            'youtubeUrl' => optional(Setting::whereType('youtubeUrl')->first())->value,
        ];
    }//..... end of getSettings() .....//
}
