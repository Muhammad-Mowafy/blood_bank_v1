<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Str;
use App\Enums\ClientStatus;
use Illuminate\Support\Facades\Hash;

/**
 * @property int $id
 * @property string $name
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string $phone
 * @property string|null $dob
 * @property string|null $last_date_of_donation
 * @property int $blood_type_id
 * @property int $city_id
 * @property ClientStatus $status
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 */

class Client extends User
{
    use HasApiTokens, HasFactory;

    protected $table = 'clients';

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'phone',
        'dob',
        'last_date_of_donation',
        'blood_type_id',
        'city_id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'status' => ClientStatus::class,
        'email_verified_at' => 'datetime',
        'dob' => 'date',
    ];

    protected $attributes = [
        'status' => ClientStatus::ACTIVE,
    ];

    public function setPasswordAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['password'] =
                Str::startsWith($value, '$2y$') ? $value : Hash::make($value);
        }
    }

    public function bloodType()
    {
        return $this->belongsTo(BloodType::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }

    public function donationRequests()
    {
        return $this->hasMany(DonationRequest::class);
    }

    public function contacts()
    {
        return $this->hasMany(ContactUs::class);
    }

    public function bloodTypes()
    {
        return $this->belongsToMany(BloodType::class);
    }

    public function governorates()
    {
        return $this->belongsToMany(Governorate::class);
    }

    public function notifications()
    {
        return $this->belongsToMany(Notification::class, 'client_notification')
            ->withPivot('is_read')
            ->withTimestamps();
    }
}
