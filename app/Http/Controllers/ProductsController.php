<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Spatie\SimpleExcel\SimpleExcelWriter;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.products.index', array_merge($this->getProductsStatus(), ['categories' => $this->getCategoriesForDropdown()]));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Manage images view
     */
    public function manageImages()
    {
        return view('admin.products.manage_images', array_merge($this->getProductsStatus(), ['categories' => $this->getCategoriesForDropdown()]));
    }//..... end of manageImages() .....//

    private function getProductsStatus()
    {
        return [
            'active' => Product::where('status', 1)->count(),
            'deActive' => Product::where('status', 0)->count(),
            'outOfStock'=> Product::where('quantity', 0)->count(),
            'aboutToOutOfStock' => Product::whereColumn('quantity', '<', 'alert_quantity')
                ->where('quantity', '>', 0)->count()
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.products.create', [
            'categories' => $this->getCategoriesForDropdown(),
            'product' => new Product(),
            'carBrands' => $this->getCarsBrandsFroDropdown(),
            'colors' => Color::get(['id', 'title', 'color'])
        ]);
    }

    /**
     * @return mixed
     * Get categories list.
     */
    public function getCategoriesForDropdown()
    {
        return Category::where('parent', 0)->pluck('title', 'id');
    }//..... end of getCategoriesForDropdown() .....//

    /**
     * @return mixed
     * Get cars brands for dropdowns.
     */
    public function getCarsBrandsFroDropdown()
    {
        return Car::where('parent', 0)->pluck('title', 'id');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function store(Request $request)
    {
        $colors = [];
        if ($request->colors)
            foreach ($request->colors as $color) {
                $clr = json_decode($color);
                $field = 'color-price-'.$clr->id;
                $clr->price = $request->$field;
                $colors[] = $clr;
            }//..... end foreach() ....//

        $data = $request->only(['title', 'category_id', 'sub_category_id', 'url', 'weight', 'quantity', 'alert_quantity',
            'sale_price', 'discount', 'discount_start_date', 'discount_end_date', 'free_items', 'description', 'car_brand_id', 'car_model_id', 'car_version', 'version_through']);

        $data['dimension'] = json_encode($request->only(['length', 'width', 'height']));
        $data['colors'] = json_encode($colors);
        $data['publish_date'] = Carbon::parse($request->publish_date)->format('Y-m-d');
        $data['status'] = $request->status == 'on' ? 1 : 0;
        if (! $request->id)
            $data['sku'] = Str::upper(Str::limit($data['title'], 3,'-')).rand(1111111, 9999999);

        $data['user_id'] = auth()->user()->id;
        $data['purchase_price'] = $request->purchase_price ? $request->purchase_price : 0;

        $images = $request->has('filesArr') && $request->filesArr ? $this->uploadsBase64Images($request->filesArr) : [];

        if ($request->selectedMedia && is_array($request->selectedMedia) and count($request->selectedMedia) > 0) {
            $imageArray = $request->selectedMedia;
            $k = 0;

            for ($i = 0; $i < count($images) + count($request->selectedMedia); $i++) {
                if (! isset($imageArray[$i])) {
                    $imageArray[$i] = $images[$k];
                    $k++;
                }
            }

            ksort($imageArray);
            $data['image'] = json_encode($imageArray);
        } else {
            $data['image'] = json_encode($images);
        }//..... end if-else() .....//

        $data['slug'] = $this->generateSlug($data['title']);

        if ($request->id)
            Product::whereId($request->id)->update($data);
        else
            Product::create($data);

        return ['status' => true, 'message' => 'Product created successfully.'];
    }

    /**
     * @param $filesArray
     * @return array
     * Upload Base64 Image and create two versions of it.
     */
    public function uploadsBase64Images($filesArray, $doNotResize = false)
    {
        $files = [];
        $opacity = $this->getWatermarkOpacity();

        foreach ($filesArray as $base64File) {
            $name = time()*rand(1111, 9999).'.png';

            if ($doNotResize) {
                Image::make($base64File)->resize(600, 600)->save(public_path('uploads/'.$name));
                Image::make($base64File)->resize(270, 270)->save(public_path('uploads/thumbs/'.$name));
            } else {
                $oi = Image::make($base64File);
                $width = $oi->width();
                $height = $oi->height();

                if ($width > 600 || $height > 600)
                    $oi->fit(600, 600, function ($constraint) {
                        $constraint->upsize();
                    });

                $canvas = Image::canvas(600, 600, 'ffffff');
                $canvas->insert($oi, 'center');
                $canvas2 = Image::canvas(600, 600, 'ffffff');
                $canvas2->insert($oi, 'center');

                //..... save image without water mark.
                $canvas2->save(public_path('uploads_extra/'.$name));

                $canvas->save(public_path('uploads/'.$name));

                $thumb_canvas = Image::canvas(270, 270, 'ffffff');
                $oi->fit(270, 270, function ($constraint) {
                    $constraint->upsize();
                });

                $thumb_canvas->insert($oi)->resize(270, 270)->save(public_path('uploads/thumbs/'.$name));
            }//..... end if-else() .....//

            $files[] = $name;
        }//..... end of uploadsBase64Images() .....//

        return $files;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);

        return view('admin.products.create', [
            'categories' => $this->getCategoriesForDropdown(),
            'product' => Product::find($id),
            'subCategories' => $this->getSubCategoryList($product->category_id),
            'carModels' => $this->getCarModelList($product->car_brand_id),
            'carBrands' => $this->getCarsBrandsFroDropdown(),
            'colors' => Color::get(['id', 'title', 'color'])
        ]);
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
        abort(404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product::destroy($id);
        return ['status' => true, 'message' => 'Product deleted successfully.'];
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \Exception List products for dataTables.
     */
    public function listProducts(Request $request)
    {
        $products = Product::query();

        switch ($request->mainFilter) {
            case 'active':
                $products->where('status', 1);
                break;
            case 'deActive':
                $products->where('status', 0);
                break;
            case 'outOfStock':
                $products->where('quantity', 0);
                break;
            case 'aboutToOutOfStock':
                $products->whereColumn('quantity', '<', 'alert_quantity')
                    ->where('quantity', '>', 0);
                break;
        }

        if ($request->has('categoryFilterId') and $request->categoryFilterId)
            $products->whereCategoryId($request->categoryFilterId);

        if ($request->has('subCategoryFilterId') and $request->subCategoryFilterId)
            $products->whereSubCategoryId($request->subCategoryFilterId);

        return DataTables::of($products)->addColumn('action', function($product){
            return '<a href="'.route('products.edit', $product->id).'" class="remove editRecord" title="Edit"><i class="fas fa-edit"></i></a>
                    |&nbsp;<a class="remove deleteRecord" href="javascript:void(0)" id="'.$product->id.'" title="Remove"><i class="fas fa-trash"></i></a>
                    |&nbsp;<a class="placeOrder" href="javascript:void(0)" title="Place order"><i class="fas fa-shopping-basket"></i></a>';
        })->make(true);
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \Exception List products for dataTables of the image management.
     */
    public function listProductsForImages(Request $request)
    {
        $products = Product::query();

        switch ($request->mainFilter) {
            case 'active':
                $products->where('status', 1);
                break;
            case 'deActive':
                $products->where('status', 0);
                break;
            case 'outOfStock':
                $products->where('quantity', 0);
                break;
            case 'aboutToOutOfStock':
                $products->whereColumn('quantity', '<', 'alert_quantity')
                    ->where('quantity', '>', 0);
                break;
        }

        if ($request->has('categoryFilterId') and $request->categoryFilterId)
            $products->whereCategoryId($request->categoryFilterId);

        if ($request->has('subCategoryFilterId') and $request->subCategoryFilterId)
            $products->whereSubCategoryId($request->subCategoryFilterId);

        return DataTables::of($products)->addColumn('action', function($product){
            return '';
        })->make(true);
    }

    /**
     * @return mixed
     * Get sub categories of a category.
     */
    public function getSubCategoryList($id = null)
    {
         return Category::where('parent', $id ?? request()->id)->pluck('title', 'id');
    }

    /**
     * @return mixed
     * Get sub categories of a category.
     */
    public function getCarModelList($id = null)
    {
         return Car::where('parent', $id ?? request()->id)->pluck('title', 'id');
    }

    /**
     * @return array
     * Load all images from uploads directory.
     */
    public function loadProductsMedia()
    {
        return Storage::disk('uploads')->files();
    }

    /**
     * @return array
     * Change product status.
     */
    public function changeStatus()
    {
        Product::whereId(request()->id)->update(['status' => request()->status]);
        return ['status' => true, 'message' => 'Status updated successfully.'];
    }

    /**
     * @return array
     * Update product single field.
     */
    public function updateProductField()
    {
        $field = request()->name;
        if ($field == 'discount_price') {
            $product = Product::find(request()->pk);

            if ($product) {
                $product->discount = $product->sale_price - request()->value;
                $product->save();
            } else
                return ['status' => false, 'message' => 'Error occurred while updating the field.'];

        } else
            Product::whereId(request()->pk)->update(["{$field}" => request()->value]);

        return ['status' => true, 'message' => 'Value updated successfully.'];
    }

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
     * @return int
     * Get watermark opacity.
     */
    private function getWatermarkOpacity()
    {
        $settings = Setting::whereType('watermarkOpacity')->first();

        return $settings ? $settings->value : 50;
    }//..... end of getWatermarkOpacity() .....//

    /**
     * @param Request $request
     * Export products.
     */
    public function export(Request $request)
    {
        $products = Product::with(['brand', 'category', 'subCategory', 'model']);

        if ($request->has('categoryId') and $request->categoryId)
            $products->whereCategoryId($request->categoryId);

        if ($request->has('subCategoryId') and $request->subCategoryId)
            $products->where('sub_category_id', $request->subCategoryId);

        $writer = SimpleExcelWriter::streamDownload('category-products.xlsx');
       // $writer = SimpleExcelWriter::create(public_path('/category-products.xlsx'));

        $products->cursor()->each(function ($row) use (&$writer) {
            $colors = [];
            foreach ($row->colors as $color)
                $colors[] = $color['title'];

            $writer->addRow([
                'Title' => $row->title,
                'Weight (kg)' => $row->weight,
                'SKU' => $row->sku,
                'Quantity' => $row->quantity,
                'Sale Price' => $row->sale_price,
                'Purchase Price' => $row->purchase_price,
                'Discount' => $row->discount,
                'Discount Start Date' => $row->discount_start_date ? $row->discount_start_date->format('Y-m-d') : '',
                'Discount Dnd Date' => $row->discount_end_date ? $row->discount_end_date->format('Y-m-d') : '',
                'Dimension' => json_encode($row->dimension),
                'Brand' => $row->brand ? $row->brand->title : '',
                'Colors' => !empty($colors) ? implode(',', $colors) : '',
                'Category' => $row->category ? $row->category->title: '',
                'SubCategory' => $row->subCategory ? $row->subCategory->title: '',
                'Model' => $row->model ? $row->model->title: '',
                'From Year' => $row->car_version,
                'To Year' => $row->version_through,
            ]);
        });

       // $writer->toBrowser();
    }//..... end of export() ....//

    /**
     * @param Request $request
     * @return array
     * Apply Bulk Discount.
     */
    public function applyBulkDiscount(Request $request)
    {
        $products = Product::query();

        if ($request->has('category_id') and $request->category_id)
            $products->whereCategoryId($request->category_id);

        if ($request->has('sub_category_id') and $request->sub_category_id)
            $products->where('sub_category_id', $request->sub_category_id);

        if (is_array($request->selectedIds) and count($request->selectedIds) > 0)
            $products->whereIn('id', $request->selectedIds);

        $products->update($request->only(['discount', 'discount_start_date', 'discount_end_date']));

        return ['status' => true, 'message' => 'Discount applied successfully.'];
    }//..... end of applyBulkDiscount() ......//

    /**
     * @return array
     * Delete product image
     */
    public function deleteProductImage()
    {
        $product = Product::findOrFail(request('id'));
        $imageArray = array_filter($product->image, function($item) {
            return $item != request('image');
        });

        ksort($imageArray);
        $product->image = json_encode(array_values($imageArray));

        $product->save();

        return ['status' => true, 'message' => 'Image deleted successfully.'];
    }//..... end of deleteProductImage() ....//

    /**
     * @return array
     * save changed image.
     */
    public function changeProductImage(Request $request)
    {
        $images = $request->has('newImage') && $request->newImage ? $this->uploadsBase64Images([$request->newImage], true) : [];

        $product = Product::findOrFail(request('id'));
        $imageArray = $product->image;

        foreach ($imageArray as $k => $v) {
            if ($v == $request->image)
                if (isset($images[0]))
                    $imageArray[$k] = $images[0];
        }//..... end foreach() .....//

        $product->image = json_encode(array_values($imageArray));

        $product->save();

        return ['status' => true, 'message' => 'Image deleted successfully.'];
    }//..... end of changeProductImage() .....//

    /**
     * @return array
     * Save images ordered array.
     */
    public function saveProductImagesOrder()
    {
        $product = Product::findOrFail(request('id'));

        $product->image = json_encode(request()->images);

        $product->save();

        return ['status' => true, 'message' => 'Images ordered saved successfully.'];
    }//..... end of saveProductImagesOrder() .....//
}//..... end of class.
