<?php

namespace App\Models\Data;

use App\Models\Data\Area;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = IdGenerator::generate(['table' => 'clients', 'field' => 'uuid', 'length' => 12, 'prefix' => 'CLN-', 'reset_on_prefix_change' => true]);
        });
    }
    public function nama(): Attribute
    {
        return new Attribute(
            get:fn($value) => strtoupper($value),
            set:fn($value) => $value,
        );
    }
    public function area()
    {
        return $this->belongsTo(Area::class, 'id_area', 'uuid');
    }
}
