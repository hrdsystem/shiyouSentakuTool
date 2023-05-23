<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class MMainItem extends Model
{
    use HasFactory, SoftDeletes;
    protected $connection = 'HRDAPPS31(shiyou_sentaku_main_test)';
    protected $table = 'm_main_items';

}
