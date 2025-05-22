<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Group extends Model
{
    use HasFactory;

    /**
     * Get the comments for the blog post.
     */
    public function items(): HasMany
    {
        return $this->hasMany(Item::class,'group_id','group_id');
    }
}
