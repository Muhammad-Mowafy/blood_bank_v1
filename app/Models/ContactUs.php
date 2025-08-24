<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ContactUs
 *
 * @property int $id
 * @property int $client_id
 * @property string $title
 * @property string $message
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @property-read Client $client
 */
class ContactUs extends Model
{
    use HasFactory;

    protected $table = 'contact_us';

    protected $fillable = [
        'client_id',
        'title',
        'message',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
