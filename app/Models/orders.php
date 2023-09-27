<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class orders extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $fillable = [
        'id_order',
        'id_table',
        'name_menu',
        'check_in',
        'check_out',
        'status',
        'check_bill'
    ];
    public $timestamps = false;
}
