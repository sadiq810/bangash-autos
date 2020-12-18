<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class PagesController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Load index view.
     */
    public function index()
    {
        return view('admin.pages.index');
    }//..... end of index() .....//

    /**
     * @return mixed
     * @throws \Exception
     */
    public function listPagesForDataTables()
    {
        return DataTables::of(Page::query())
            ->addColumn('status', function ($page) {
              return $page->status ? 'Active' : 'DeActive';
            })->addColumn('action', function($page){
            return '<a href="'.route('page.edit', $page->id).'" class="remove editRecord" title="Edit"><i class="fas fa-edit"></i></a>
                    |&nbsp;<a class="remove deleteRecord" href="javascript:void(0)" id="'.$page->id.'" title="Remove"><i class="fas fa-trash"></i></a>';
        })->make(true);
    }//..... end of listPagesForDataTables() .....//

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Load create view.
     */
    public function create()
    {
        return view('admin.pages.create', ['page' => new Page()]);
    }//..... end of create() .....//

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        return view('admin.pages.create', ['page' => Page::findOrFail($id)]);
    }//..... end edit() .....//

    /**
     * @param Request $request
     * @return array
     * Save page.
     */
    public function save(Request $request)
    {
        $data = $request->only(['title', 'location', 'detail']);
        $data['status'] = $request->has('status') ? 1 : 0;

        if ($request->has('id') and $request->id) {
            Page::whereId($request->id)->update($data);
        } else {
            $data['slug'] = Str::slug($request->title, '-');
            Page::create($data);
        }//..... end if-else() .....//

        return ['status' => true, 'message' => 'Page saved successfully', 'redirect' => $request->id];
    }//..... save() .....//

    /**
     * @param $id
     * @return array
     */
    public function destroy($id)
    {
        Page::destroy($id);
        return ['status' => true, 'message' => "Page deleted successfully"];
    }//..... end of destroy() .....//

    /**
     * @param string $location
     * @return mixed
     */
    public function getPages()
    {
        return [
            'headerPages' => Page::where('status', 1)->where('location', 'header')->get(['title', 'slug']),
            'footerPages' => Page::where('status', 1)->where('location', 'footer')->get(['title', 'slug'])
        ];
    }//..... end of getPages() ....//

    /**
     * @return array
     * Get page details by slug
     */
    public function getPageDetailBySlug()
    {
        return ['status' => true, 'data' => Page::where('slug', request()->pageName)->first()];
    }//.... end of getPageDetailBySlug() ......//
}
