<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class SettingsController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Load main view for watermark settings.
     */
    public function index()
    {
        return view('admin.settings.watermark_settings', [
            'settings' => Setting::whereType('watermarkOpacity')->first()
        ]);
    }//..... end of index() .....//

    /**
     * Save watermark settings.
     */
    public function saveWatermarkSettings()
    {
        Setting::updateOrCreate(['type' => 'watermarkOpacity'], ['value' => request()->opacity]);
        return redirect()->route('watermark.settings.index');
    }//..... end of saveWatermarkSettings() .....//

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Various Contact settings.
     */
    public function phoneEmailSettings()
    {
        return view('admin.settings.phone_email_settings', [
            'phone' => Setting::whereType('phone')->first(),
            'contactEmail' => Setting::whereType('contactEmail')->first(),
            'officeAddress' => Setting::whereType('officeAddress')->first(),
            'adminEmail' => Setting::whereType('adminEmail')->first(),
            'facebookPageUrl' => Setting::whereType('facebookPageUrl')->first(),
            'twitterUrl' => Setting::whereType('twitterUrl')->first(),
            'pinterestUrl' => Setting::whereType('pinterestUrl')->first(),
            'youtubeUrl' => Setting::whereType('youtubeUrl')->first(),
            'shipCostMethod' => Setting::whereType('shipCostMethod')->first(),
            'perKgCharges' => Setting::whereType('perKgCharges')->first(),
        ]);
    }//..... end of phoneEmailSettings() .....//

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * Save various Settings.
     */
    public function savePhoneEmailSettings(Request $request)
    {
        Setting::updateOrCreate(['type' => 'phone'], ['value' => $request->phone]);
        Setting::updateOrCreate(['type' => 'contactEmail'], ['value' => $request->contactEmail]);
        Setting::updateOrCreate(['type' => 'officeAddress'], ['value' => $request->officeAddress]);
        Setting::updateOrCreate(['type' => 'adminEmail'], ['value' => $request->adminEmail]);
        Setting::updateOrCreate(['type' => 'facebookPageUrl'], ['value' => $request->facebookPageUrl]);
        Setting::updateOrCreate(['type' => 'twitterUrl'], ['value' => $request->twitterUrl]);
        Setting::updateOrCreate(['type' => 'pinterestUrl'], ['value' => $request->pinterestUrl]);
        Setting::updateOrCreate(['type' => 'youtubeUrl'], ['value' => $request->youtubeUrl]);
        Setting::updateOrCreate(['type' => 'shipCostMethod'], ['value' => $request->shipCostMethod]);
        Setting::updateOrCreate(['type' => 'perKgCharges'], ['value' => $request->perKgCharges]);

        if ($request->hasFile('image')) {
            $name = time()*rand(1111, 9999).'.jpg';
            Image::make($request->image)->resize(271, 555)->save(public_path('uploads/'.$name));
            Setting::updateOrCreate(['type' => 'saleCategoryImage'], ['value' => $name]);
        }//..... end if() .....//

        return redirect()->route('phone.email.settings');
    }//..... end of savePhoneEmailSettings() ......//
}//..... end of class.
