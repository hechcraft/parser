<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Offers
 *
 * @property int $id
 * @property int|null $page_id
 * @property string $name
 * @property string $image_url
 * @property string $last_checked_at
 * @property string $offer_url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Offers extends Model
{
    use HasFactory;

    protected $guarded = [];
}
