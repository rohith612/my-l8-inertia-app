<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ProductsImages extends Model
{
    use HasFactory;

    protected $appends = [
        'file_main_url',
    ];
    
    protected $fillable = [
        'product_id ',
        'image_name',
    ];

    /**
     * Get the product main image file.
     *
     * @return url
     */
    public function getFileMainUrlAttribute(){
        return Storage::url(config('config.MAIN_PATH').$this->image_name);
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'id' , 'product_id');
    }
}
