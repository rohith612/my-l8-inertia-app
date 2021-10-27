<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    protected $perPage = 5;

    protected $appends = [
        'file_thumb_url', 
        'file_main_url',
    ];

    protected $fillable = [
        'name',
        'product_code',
        'shipping_code',
        'description',
        'price',
        'batch',
        'quantity',
        'category',
        'picture_path',
    ];

    /**
     * Get the product thumb image file.
     *
     * @return url
     */
    public function getFileThumbUrlAttribute(){
        return Storage::url(config('config.THUMB_PATH').$this->picture_path);
    }
    /**
     * Get the product main image file.
     *
     * @return url
     */
    public function getFileMainUrlAttribute(){
        return Storage::url(config('config.MAIN_PATH').$this->picture_path);
    }
    /**
     * relations here
     *
     * @return url
     */
    public function additionalImages(){
        return $this -> hasMany(ProductsImages::class, 'product_id', 'id');
    }

    public function productCategory(){
        return $this -> hasOne(Category::class, 'id', 'category');
    }

}
