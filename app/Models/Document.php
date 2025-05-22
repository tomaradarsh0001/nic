<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Document extends Model
{
    use HasFactory;
    protected $guarded = [];

    // Define the relationship with User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id'); //Here user_id is foraign key on documents table & id is primary key from user table
    }

    public function userProperty()
    {
        return $this->belongsTo(UserProperty::class, 'property_master_id', 'new_property_id');
    }

    public function documentKeys(): HasMany
    {
        return $this->hasMany(DocumentKey::class, 'document_id');
    }

    public function documentFinalChecklist(): HasOne
    {
        return $this->hasOne(DocumentChecklist::class);
    }
}
