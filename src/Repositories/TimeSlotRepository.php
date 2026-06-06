<?php

namespace App\Repositories;

class TimeSlotRepository extends BaseRepository {
    protected string $table = 'time_slots';
    protected string $primaryKey = 'time_slot_id';
    protected array $fillable = ['slot_name', 'start_time', 'end_time'];
}
