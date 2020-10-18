<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 * 
 * @property int $id
 * @property string $name
 * @property string $username
 * @property string $password
 * @property string|null $kelas
 * @property string|null $semester
 * @property int $level
 * @property int $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property Collection|Schedule[] $schedules
 * @property Collection|Supervisor[] $supervisors
 *
 * @package App\Models
 */
class User extends Model
{
	protected $table = 'users';

	protected $casts = [
		'level' => 'int',
		'status' => 'int'
	];

	protected $hidden = [
		'password'
	];

	protected $fillable = [
		'name',
		'username',
		'password',
		'kelas',
		'semester',
		'level',
		'status'
	];

	public function schedules()
	{
		return $this->hasMany(Schedule::class);
	}

	public function supervisors()
	{
		return $this->hasMany(Supervisor::class);
	}
}
