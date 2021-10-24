<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Item extends Model
{
    use HasFactory;
    
    protected $perPage = 5;

    protected $appends = ['created_date'];

    protected $fillable = [
        'name',
    ];

    public function getCreatedDateAttribute(){
        return Carbon::create($this->created_at)->isoFormat('LLLL');
    }

    

}
