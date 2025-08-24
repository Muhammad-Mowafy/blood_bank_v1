<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DonationRequest
 *
 * @property int $id
 * @property string $name
 * @property int $age
 * @property int $blood_type_id
 * @property int $number_of_bags
 * @property float $latitude
 * @property float $longitude
 * @property int $city_id
 * @property string $phone
 * @property string|null $comments
 * @property int $client_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @property-read BloodType $bloodType
 * @property-read City $city
 * @property-read Client $client
 * @property-read \Illuminate\Database\Eloquent\Collection|Notification[] $notifications
 */
class DonationRequest extends Model
{
    use HasFactory;

    protected $table = 'donation_requests';

    protected $fillable = [
        'name',
        'age',
        'blood_type_id',
        'number_of_bags',
        'latitude',
        'longitude',
        'city_id',
        'phone',
        'comments',
        'client_id'
    ];

    public function bloodType()
    {
        return $this->belongsTo(BloodType::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
}
