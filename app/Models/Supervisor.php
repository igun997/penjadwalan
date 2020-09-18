<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Supervisor
 * 
 * @property int $id
 * @property int $user_id
 * @property int $handler_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property User $user
 * @property Handler $handler
 *
 * @package App\Models
 */
class Supervisor extends Model
{
	protected $table = 'supervisors';

	protected $casts = [
		'user_id' => 'int',
		'handler_id' => 'int'
	];

	protected $fillable = [
		'user_id',
		'handler_id'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function handler()
	{
		return $this->belongsTo(Handler::class);
	}
}
