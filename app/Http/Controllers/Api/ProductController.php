<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * @param $category_id
     * @return array
     */
    public function getCategoryProducts($category_id)
    {
        $limit = 20;
        $skip = request()->skip ?? 0;

        $products = Product::where('category_id', $category_id)->active()->published();
        $total = $products->count();
        $products = $products->skip($skip)->limit($limit)->orderBy('id', 'DESC')->get();
        $products = $this->validateDiscount($products);
        return ['status' => true, 'data' => ['total' => $total, 'loaded' => $skip + $products->count(), 'products' => $products]];
    }

    /**
     * @param Request $request
     * Get Category products with pagination
     * @return array
     */
    public function getCategoryProductsPaginate(Request $request)
    {
        return $this->getProducts($request);
    }//..... end of getCategoryProductsPaginate() .....//

    /**
     * @param Request $request
     * Get discounted products.
     * @return array
     */
    public function getDiscountedProductsPaginate(Request $request)
    {
        return $this->getProducts($request, true);
    }//..... end of getDiscountedProductsPaginate() .....//

    /**
     * @param Request $request
     * @return array
     * Get new arrivals.
     */
    public function newArrivalsPaginate(Request $request)
    {
        return $this->getProducts($request);
    }//..... end of newArrivalsPaginate() ......//

    /**
     * @param Request $request
     * @return array
     * Get filtered products.
     */
    public function filteredProductsPaginate(Request $request)
    {
        return $this->getProducts($request);
    }//..... end of filteredProductsPaginate() ....//

    /**
     * @param $request
     * @param bool $onlyDiscountedProducts
     * @return array
     * Get Products.
     */
    private function getProducts($request, $onlyDiscountedProducts = false)
    {
        $products = Product::active()->published()->orderBy('id', 'DESC');

        if ($request->has('searchText') and $request->searchText)
            $products->where('title', 'LIKE', '%'.$request->searchText.'%');

        if (is_array($request->categories) and count($request->categories) > 0)
            $products->whereIn('category_id', $request->categories);

        if (is_array($request->subCategories) and count($request->subCategories) > 0)
            $products->whereIn('sub_category_id', $request->subCategories);

        if ($request->has('min') and $request->has('max'))
            $products->where('sale_price', '>=', $request->min)->where('sale_price', '<=', $request->max);

        if ($request->category_id)
            $products->where('category_id', $request->category_id);

        if ($onlyDiscountedProducts) {
            $date = today()->format('Y-m-d');
            $products->where('discount', '>', 0)
                ->whereRaw('CASE WHEN discount_start_date IS NOT NULL AND discount_end_date IS NOT NULL THEN discount_start_date <= \''.$date.'\' AND discount_end_date >= \''.$date.'\'  ELSE TRUE END');
        }//..... end if() .....//

        if ($request->year)
            $products->where('car_version', '<=', $request->year)->where('version_through', '>=', $request->year);

        if ($request->brand)
            $products->where('car_brand_id', $request->brand);

        if ($request->model)
            $products->where('car_model_id', $request->model);

        $products = $products->paginate(20);
        $total = $products->total();
        $current_page = $products->currentPage();
        $perPage = $products->perPage();
        return ['status' => true, 'data' => $this->validateDiscount($products), 'total' => $total, 'currentPage' => $current_page, 'perPage' => $perPage];
    }//..... end of getProducts() .....//

    /**
     * @param Request $request
     * @return array
     */
    public function getCategoriesProducts(Request $request)
    {
        $limit = 20;
        $prdCollection = collect([]);

        foreach ($request->ids as $id) {
            $products = Product::active()->published()->where('category_id', $id);
            $total = $products->count();
            $products = $products->orderBy('priority', 'DESC')->limit($limit)->get();
            $products = $this->validateDiscount($products);
            $prdCollection->put($id, ['total' => $total, 'loaded' => $products->count(), 'products' => $products]);
        }//..... end foreach() .....//

        return ['status' => true, 'data' => $prdCollection];
    }

    /**
     * @param Collection $product
     * @return Collection
     * Validate discount of each product.
     */
    public function validateDiscount($product)
    {
        return $product->each(function($prd) {
            $prd->shortTitle = Str::words($prd->title, 10);
            if (!$prd->discount)
                $prd->discount = 0;

            if ($prd->discount > 0) {
             if ($prd->discount_start_date && $prd->discount_end_date) {
                 if (! ($prd->discount_start_date->lessThanOrEqualTo(now()) and $prd->discount_end_date->greaterThanOrEqualTo(now())))
                     $prd->discount = 0;
             } elseif ($prd->discount_start_date and !$prd->discount_end_date) {
                 if (!$prd->discount_start_date->lessThanOrEqualTo(now()))
                     $prd->discount = 0;
             } elseif (!$prd->discount_start_date and $prd->discount_end_date)
                 if (!$prd->discount_end_date->greaterThanOrEqualTo(now()))
                     $prd->discount = 0;
            }

            $prd->final_price = $prd->sale_price;

            if ($prd->discount > 0)
                $prd->final_price = $prd->sale_price - $prd->discount;
        });
    }

    /**
     * @return array
     * Search product.
     */
    public function searchProduct()
    {
        $search = explode(' ', request()->search);

        preg_match_all('!\d+!', request()->search, $matches);

        $dates = Arr::flatten($matches);

        foreach($search as $key => $value)
            if (strlen($value) == 4 && in_array($value, $dates))
                unset($search[$key]);
            else if (($key = array_search($value, $dates)) !== false)
                unset($dates[$key]);

        $products = Product::active()->published();

        if (request()->brand)
            $products->where('car_brand_id', request('brand'));

        if (request()->model)
            $products->where('car_model_id', request('model'));

        if (request('year'))
            $products->where(function($query) {
                return $query->where('car_version', '<=', request()->year)
                    ->where('version_through', '>=', request()->year);
            });

        if (count($dates) > 0)
            $products->where(function($query) use($dates) {
                return $query->where('car_version', '<=', $dates[0])
                    ->where('version_through', '>=', $dates[0]);
            });

        $products->where(function($query) use($search) {
            foreach ($search as $str)
                if ($str)
                    $query->where('title', 'LIKE', "%".$str."%");

            return $query;
        });

        return ['status' => true, 'data' => $this->validateDiscount($products->limit(100)->latest()->get()->each(function($p) use($search, $dates) {
            foreach ($search as $s) {
                if ($s)
                    $p->title = preg_replace('/(' . $s . ')/i', "<b>$1</b>", $p->title);
            }

            if (isset($dates[0]))
                $p->title = preg_replace('/(' . $dates[0] . ')/i', "<b>$1</b>", $p->title);
        }))];
    }//..... end of searchProduct() .....//

    /**
     * @return array
     * Get Product by slug.
     */
    public function getProductBySlug()
    {
        $products = Product::where('slug', request()->slug)->active()->published()->get();
        return ['status' => true, 'data' => $this->validateDiscount($products), 'relatedProducts' => $this->getRelatedProducts($products->first())];
    }//..... end of getProductBySlug() ......//

    /**
     * @param $product
     * @return mixed
     * Get related products.
     */
    private function getRelatedProducts($product)
    {
        if (!$product)
            return [];

        $products = Product::active()->published()->orderBy('id', 'DESC')->limit(25)->where('id', '!=', $product->id);

        if ($product->car_brand_id) {
            $products->where('car_brand_id', $product->car_brand_id);
            if ($product->car_version && $product->version_through)
                $products->where('car_version', '>=', $product->car_version)
                    ->where('version_through', '<=', $product->version_through);
        } else
            $products->where('category_id', $product->category_id);

        return $this->validateDiscount($products->get());
    }//..... end of getRelatedProducts() ....//
}
