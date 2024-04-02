<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $with = ['children'];

    public function children(): HasMany
    {
        return $this->hasMany(Menu::class, 'parent_id', 'id');
    }
}
