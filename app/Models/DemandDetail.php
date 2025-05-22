<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DemandDetail extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $appends = ['subhead_name'];
    public function demand(): BelongsTo
    {
        return $this->belongsTo(Demand::class, 'demand_id', 'id');
    }
    public function getSubheadNameAttribute()
    {
        return getServiceNameById($this->subhead_id);
    }
    public function getSubheadCodeAttribute()
    {
        return getServiceCodeById($this->subhead_id);
    }
    public function getSubheadKeysAttribute()
    {
        $headKeys = DemandHeadKey::where('head_id', $this->id)->pluck('value', 'key')->toArray();
        return $headKeys;
    }
}