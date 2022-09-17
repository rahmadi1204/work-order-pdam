<?php

namespace App\Models\Type;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TypeWorkOrder extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];
}
