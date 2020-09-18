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
 * @property Carbon|null $start
 * @property Carbon|null $end
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
		'start',
		'end'
	];

	protected $fillable = [
		'room_id',
		'handler_1',
		'handler_2',
		'handler_3',
		'user_id',
		'start',
		'end',
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
    public function handler_1()
    {
        return $this->belongsTo(Handler::class, 'handler_1');
    }
    public function handler_2()
    {
        return $this->belongsTo(Handler::class, 'handler_2');
    }
	public function handler_3()
	{
		return $this->belongsTo(Handler::class, 'handler_3');
	}
}
