<?php

namespace App\Repositories;

class AmenityRepository extends BaseRepository
{
    protected string $table = 'amenities';
    protected string $primaryKey = 'amenity_id';
    protected array $fillable = ['name', 'description'];
}
