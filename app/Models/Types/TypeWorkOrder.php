<?php

namespace App\Models\Types;

use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TypeWorkOrder extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = IdGenerator::generate(['table' => 'type_work_orders', 'field' => 'uuid', 'length' => 12, 'prefix' => 'TWO-', 'reset_on_prefix_change' => true]);
        });
    }
}
