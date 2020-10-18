<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Handler
 * 
 * @property int $id
 * @property int $nip
 * @property string $name
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property Collection|Schedule[] $schedules
 * @property Collection|Supervisor[] $supervisors
 *
 * @package App\Models
 */
class Handler extends Model
{
	protected $table = 'handlers';

	protected $casts = [
		'nip' => 'int'
	];

	protected $fillable = [
		'nip',
		'kelas',
		'semester',
		'name'
	];

	public function schedules()
	{
		return $this->hasMany(Schedule::class, 'handler_3');
	}

	public function supervisors()
	{
		return $this->hasMany(Supervisor::class);
	}
}
