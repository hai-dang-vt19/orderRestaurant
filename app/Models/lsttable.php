<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class lsttable extends Model
{
    use HasFactory;
    protected $table = 'lsttable';
    protected $fillable = [
        'member','des','status','id_area'
    ];
    public $timestamps = false;
}
