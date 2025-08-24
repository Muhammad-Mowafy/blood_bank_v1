<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class City
 *
 * @property int $id
 * @property string $name
 * @property int $governorate_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|Client[] $clients
 * @property-read Governorate $governorate
 * @property-read \Illuminate\Database\Eloquent\Collection|DonationRequest[] $donationRequests
 */
class City extends Model
{
    protected $fillable = ['name', 'governorate_id'];

    public function clients()
    {
        return $this->hasMany(Client::class);
    }

    public function governorate()
    {
        return $this->belongsTo(Governorate::class);
    }

    public function donationRequests()
    {
        return $this->hasMany(DonationRequest::class);
    }
}
