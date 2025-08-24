<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Governorate
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|City[] $cities
 * @property-read \Illuminate\Database\Eloquent\Collection|Client[] $clients
 */
class Governorate extends Model
{
    protected $table = 'governorates';
    protected $fillable = ['name'];

    public function cities()
    {
        return $this->hasMany(City::class);
    }

    public function clients()
    {
        return $this->belongsToMany(Client::class);
    }
}
