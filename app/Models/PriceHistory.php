<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * App\Models\PriceHistory
 *
 * @property int $id
 * @property int $offer_id
 * @property string $price
 * @property string $checked_at
 */
class PriceHistory extends Model
{
    use HasFactory;

    public $sortable = ['price'];

    protected $guarded = [];
    public $timestamps = false;

    public function offer(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Offers::class);
    }
}
