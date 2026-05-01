<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopItem extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'type', 'price', 'icon', 'preview_image'];

    public function purchases()
    {
        return $this->hasMany(UserPurchase::class);
    }
}
