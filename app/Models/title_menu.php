<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class title_menu extends Model
{
    use HasFactory;
    protected $table = 'title_menu';
    protected $fillable = [
        'title','name_title'
    ];
    public $timestamps = false;
}
