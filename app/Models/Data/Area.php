<?php

namespace App\Models\Data;

use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Area extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = IdGenerator::generate(['table' => 'areas', 'field' => 'uuid', 'length' => 12, 'prefix' => 'KEC-', 'reset_on_prefix_change' => true]);
        });
    }
    public function namaArea(): Attribute
    {
        return new Attribute(
            get:fn($value) => strtoupper($value),
            set:fn($value) => $value,
        );
    }
}
