<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Yajra\DataTables\Facades\DataTables;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.categories.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort(401);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->has('id') and $request->id)
            return $this->update($request, $request->id);

        $validator = Validator::make($request->all(), [
            'title' => 'required'
        ]);

        if ($validator->fails())
            return ['status' => false, 'validationError' => implode(' ', $validator->getMessageBag()->all())];

        $data = $request->only(['title']);
        $data['status'] = $request->status ? 1 : 0;

        if ($request->has('parent'))
            $data['parent'] = $request->parent;

        $data['slug'] = $this->generateSlug($data['title']);

        if ($request->hasFile('image')) {
            $name = time()*rand(1111, 9999).'.jpg';
            Image::make($request->image)->resize(271, 555)->save(public_path('uploads/'.$name));
            $data['image'] = $name;
        }//..... end if() .....//

        Category::create($data);

        return ['status' => true, 'message' => 'Category saved successfully.'];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort(401);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort(401);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required'
        ]);

        if ($validator->fails())
            return ['status' => false, 'validationError' => implode(' ', $validator->getMessageBag()->all())];

        $data = $request->only(['title']);
        $data['slug'] = $this->generateSlug($data['title']);
        $data['status'] = $request->status ? 1 : 0;

        if ($request->hasFile('image')) {
            $name = time()*rand(1111, 9999).'.jpg';
            Image::make($request->image)->resize(271, 555)->save(public_path('uploads/'.$name));
            $data['image'] = $name;
        }//..... end if() .....//

        Category::whereId($id)->update($data);
        return ['status' => true, 'message' => 'Category updated successfully.'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Category::destroy($id);
        return ['status' => true, 'message' => 'Category deleted successfully.'];
    }

    /**
     * @return mixed
     * @throws \Exception
     * List categories for dataTables.
     */
    public function listCategories()
    {
        return DataTables::of(Category::where('parent', 0)->withCount('subCategories'))->addColumn('action', function($category){
            return '<a href="javascript: void(0)" data-id="'.$category->id.'" data-json=\''. json_encode($category->only(['title', 'status'])) .'\' class="remove editRecord" title="Edit"><i class="fas fa-edit"></i></a>
                    |&nbsp;<a class="remove deleteRecord" href="javascript:void(0)" id="'.$category->id.'" title="Remove"><i class="fas fa-trash"></i></a>
                    |&nbsp;<a class="remove selectCategoryProducts" href="javascript:void(0)" data-id="'.$category->id.'" title="Select top 20 products for this category."><i class="fas fa-list"></i></a>';
        })->make(true);
    }//..... end of listCategories() ......//

    /**
     * @return mixed
     * @throws \Exception
     * List sub categories for dataTables.
     */
    public function listSubCategories()
    {
        return DataTables::of(Category::where('parent', request()->_id))->addColumn('action', function($category){
            return '<a href="javascript: void(0)" data-id="'.$category->id.'" data-parent="'.$category->parent.'" data-json=\''. json_encode($category->only('title')) .'\' class="remove editSubRecord" title="Edit"><i class="fas fa-edit"></i></a>
                    |&nbsp;<a class="remove deleteSubRecord" href="javascript:void(0)" data-parent="'.$category->parent.'"  id="'.$category->id.'" title="Remove"><i class="fas fa-trash"></i></a>';
        })->make(true);
    }//..... end of listSubCategories() ......//

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Get categories for sorting.
     */
    public function loadCategorySortingView()
    {
        return view('admin.categories.sort', ['categories' => Category::where('parent', 0)->orderBy('order', 'asc')->get()]);
    }//..... end of loadCategorySortingView() .....//

    /**
     * @return array
     * Saving categories sorting.
     */
    public function saveSorting()
    {
        foreach (request()->ids as $key => $id)
            Category::whereId($id)->update(['order' => ($key + 1)]);

        return ['status' => true, 'message' => 'Sorting saved successfully'];
    }//..... end of saveSorting() ......//

    /**
     * @param $title
     * Generate category slug.
     * @return mixed|string
     */
    private function generateSlug($title)
    {
        $title = str_replace('&','and', $title);
        $title = str_replace(' ','-', $title);
        $title = str_replace('/','-', $title);
        $title = strtolower($title);
        return $title;
    }//..... end of generateSlug() .....//

    /**
     * @return mixed
     * Get category's sub categories.
     */
    public function loadCategorySubCategories()
    {
        return Category::where('parent', request()->id)->pluck('title', 'id');
    }//..... end of loadCategorySubCategories() .....//

    /**
     * Load Category's Products.
     */
    public function loadCategoryProducts()
    {
        return [
            'status' => true,
            'data' => Product::select('id', 'title', 'slug', 'priority')->where('category_id', request('id'))->get()
        ];
    }//..... end of loadCategoryProducts() .....//

    /**
     * @return array
     * Save category top 20 products list.
     */
    public function saveCategoryProducts()
    {
        Product::where('category_id', request('category_id'))->update(['priority' => 0]);
        Product::whereIn('id', request('ids'))->update(['priority' => 1]);

        return ['status' => true, 'message' => 'Category products saved successfully.'];
    }//..... end of saveCategoryProducts() .....//
}
