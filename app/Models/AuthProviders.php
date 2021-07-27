<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\AuthProviders
 *
 * @property int $id
 * @property int $user_id
 * @property string $provider
 * @property int $provider_id
 */
class AuthProviders extends Model
{
    use HasFactory;
}
