<?php

namespace App\Http\Controllers;

use App\ContactUs;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Yajra\DataTables\Facades\DataTables;

class ContactUsController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.contact_us.index');
    }

    /**
     * @param $id
     * @return array
     */
    public function destroy($id)
    {
        ContactUs::destroy($id);
        return ['status' => true, 'message' => "Contact deleted successfully"];
    }//..... end of destroy() .....//

    /**
     * @return mixed
     * @throws \Exception
     */
    public function listContactForDataTables()
    {
        return DataTables::of(ContactUs::query())
            ->addColumn('action', function($page){
                return '<a class="remove deleteRecord" href="javascript:void(0)" id="'.$page->id.'" title="Remove"><i class="fas fa-trash"></i></a>';
            })->make(true);
    }//..... end of listContactForDataTables() .....//

    /**
     * @param Request $request
     * @return array
     * Save contact us feedback.
     */
    public function saveContactUsFeedback(Request $request)
    {
        $data = $request->only(['name', 'email', 'detail', 'phone']);
        if ($request->image) {
            $name = time()*rand(1111, 9999).'.jpg';
            Image::make($request->image)->save(public_path('uploads/'.$name));
            $data['image'] = $name;
        }//..... end if() ....//

        ContactUs::create($data);
        return ['status' => true, 'message' => 'Feedback received successfully.'];
    }//..... end of saveContactUsFeedback() .....//
}
