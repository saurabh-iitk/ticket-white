<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $table = "sections";
    protected $primaryKey = "id";
    protected $guarded = [];

    public function pricingCategory()
    {
        return $this->belongsTo(PricingCategory::class, 'pricing_category_id');
    }
}
