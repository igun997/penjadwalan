<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Schedule
 * 
 * @property int $id
 * @property int $room_id
 * @property int $handler_1
 * @property int $handler_2
 * @property int $handler_3
 * @property int $user_id
 * @property Carbon|null $start_date
 * @property Carbon|null $start_time
 * @property Carbon|null $end_time
 * @property int $type
 * @property int $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property User $user
 * @property Room $room
 * @property Handler $handler
 *
 * @package App\Models
 */
class Schedule extends Model
{
	protected $table = 'schedules';

	protected $casts = [
		'room_id' => 'int',
		'handler_1' => 'int',
		'handler_2' => 'int',
		'handler_3' => 'int',
		'user_id' => 'int',
		'type' => 'int',
		'status' => 'int'
	];

	protected $dates = [
		'start_date'
	];

	protected $fillable = [
		'room_id',
		'handler_1',
		'handler_2',
		'handler_3',
		'user_id',
		'start_date',
		'start_time',
		'end_time',
		'type',
		'status'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function room()
	{
		return $this->belongsTo(Room::class);
	}

	public function pembimbing()
	{
		return $this->belongsTo(Handler::class, 'handler_1');
	}
    public function penguji_satu()
    {
        return $this->belongsTo(Handler::class, 'handler_2');
    }
    public function penguji_dua()
    {
        return $this->belongsTo(Handler::class, 'handler_3');
    }
}
