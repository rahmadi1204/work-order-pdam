<?php

namespace App\Models\Data;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StaffCategory extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];

    public function nama(): Attribute
    {
        return new Attribute(
            get:fn($value) => strtoupper($value),
            set:fn($value) => $value,
        );
    }
}
