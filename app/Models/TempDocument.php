<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TempDocument extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function tempDocumentKeys(): HasMany
    {
        return $this->hasMany(TempDocumentKey::class, 'temp_document_id');
    }
}
