<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    protected $keyType = 'string';
    public $incrementing = false;

    protected $casts = [
        'id' => 'string',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });

        static::created(function ($menu) {
            $menu->createRootMenuItem();
        });
    }

    public function items()
    {
        return $this->hasMany(MenuItem::class);
    }

    public function createRootMenuItem()
    {
        return $this->items()->create([
            'name' => $this->name,
            'parent_id' => null,
            'position' => 0,
        ]);
    }
}