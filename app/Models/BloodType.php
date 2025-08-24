<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BloodType
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|Client[] $directClients
 * @property-read \Illuminate\Database\Eloquent\Collection|DonationRequest[] $donationRequests
 * @property-read \Illuminate\Database\Eloquent\Collection|Client[] $clients
 */
class BloodType extends Model
{
    protected $table = "blood_types";
    protected $fillable = ['name'];

    public function directClients()
    {
        return $this->hasMany(Client::class);
    }

    public function donationRequests()
    {
        return $this->hasMany(DonationRequest::class);
    }

    public function clients()
    {
        return $this->belongsToMany(Client::class);
    }
}
