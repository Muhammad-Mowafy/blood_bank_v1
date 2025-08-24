<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Notification
 *
 * @property int $id
 * @property string $title
 * @property string $message
 * @property int|null $donation_request_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @property-read \DonationRequest $donationRequest
 * @property-read \Illuminate\Database\Eloquent\Collection|Client[] $clients
 */
class Notification extends Model
{
    protected $table = 'notifications';

    protected $fillable = [
        'title',
        'message',
        'donation_request_id'
    ];

    public function donationRequest()
    {
        return $this->belongsTo(DonationRequest::class);
    }

    public function clients()
    {
        return $this->belongsToMany(Client::class, 'client_notification')
            ->withPivot('is_read')
            ->withTimestamps();
    }
}
