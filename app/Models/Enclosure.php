<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Enclosure extends Model
{
    /** @use HasFactory<\Database\Factories\EnclosureFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'limit',
        'feeding_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'limit' => 'integer',
            'feeding_at' => 'datetime',
        ];
    }

    public function users() : BelongsToMany {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function animals() : HasMany {
        return $this->hasMany(Animal::class);
    }

    public function arePredators() : Bool {
        return $this->animals->first()?->is_predator ?? false;
    }
}
