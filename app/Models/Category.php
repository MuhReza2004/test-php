<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['kode', 'nama'];

    /**
     * Relationship to MasterItem (Many-to-Many)
     */
    public function masterItems()
    {
        return $this->belongsToMany(MasterItem::class, 'category_master_item', 'category_id', 'master_item_id');
    }
}
