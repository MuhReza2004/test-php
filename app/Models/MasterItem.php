<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterItem extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $appends = ['harga_jual', 'foto_url'];

    /**
     * Relationship to Category (Many-to-Many)
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_master_item', 'master_item_id', 'category_id');
    }

    /**
     * Accessor for Harga Jual
     */
    public function getHargaJualAttribute()
    {
        return round($this->harga_beli + ($this->harga_beli * $this->laba / 100));
    }

    /**
     * Accessor for Foto URL
     */
    public function getFotoUrlAttribute()
    {
        if ($this->foto) {
            return asset('storage/items/' . $this->foto);
        }
        return 'https://via.placeholder.com/150';
    }
}
