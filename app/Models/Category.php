<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Category extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = ['name'];

    protected $guarded = [];
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }
}
