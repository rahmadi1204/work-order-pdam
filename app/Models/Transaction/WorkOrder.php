<?php

namespace App\Models\Transaction;

use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkOrder extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = IdGenerator::generate(['table' => 'work_orders', 'field' => 'uuid', 'length' => 12, 'prefix' => 'WO-', 'reset_on_prefix_change' => true]);
        });
    }
    public function staff()
    {
        return $this->belongsTo('App\Models\Data\Staff', 'staff_id', 'kode_jabatan');
    }
    public function client()
    {
        return $this->belongsTo('App\Models\Data\Client', 'client_id', 'no_sambungan');
    }
    public function type()
    {
        return $this->belongsTo('App\Models\Types\TypeWorkOrder', 'type_id', 'kode_work_order');
    }
}
