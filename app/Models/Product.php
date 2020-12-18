<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    protected $hidden = ['updated_at', 'deleted_at'];

    protected $dates = ['discount_start_date', 'discount_end_date'];

    /**
     * @param $image
     * @return mixed
     */
    public function getImageAttribute($image)
    {
        return json_decode($image);
    }

    /**
     * @param $colors
     * @return mixed
     */
    public function getColorsAttribute($colors)
    {
        return collect($colors ? json_decode($colors, true) : []);
    }
    /**
     * @param $image
     * @return mixed
     */
    public function getDimensionAttribute($dimension)
    {
        return json_decode($dimension, true);
    }

    /**
     * @param $query
     * @return mixed
     * Published Scope.
     */
    public function ScopePublished($query)
    {
        //$time = now()->format('H:i:s');
        $date = now()->format('Y-m-d');

        return $query->where(function ($query) use($date) {
            return $query->whereDate('publish_date', '<=', now());
                //->whereRaw("CASE WHEN DATE(publish_date) = '{$date}' THEN TIME(publish_date) < '{$time}' ELSE TRUE END");//->whereTime('publish_date', '<', now());
        });
    }

    /**
     * @param $query
     * @return mixed
     * Active scope.
     */
    public function ScopeActive($query)
    {
        return $query->where('status', 1);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function brand()
    {
        return $this->belongsTo(Car::class, 'car_brand_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function model()
    {
        return $this->belongsTo(Car::class, 'car_model_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subCategory()
    {
        return $this->belongsTo(Category::class, 'sub_category_id', 'id');
    }
}
