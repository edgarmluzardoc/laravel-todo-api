<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Task extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'date',
        // 'completed',
    ];

    /**
     * Relationship with users
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'task_user')
            ->withTimestamps()
            ->withPivot(['completed']);
        // return $this->belongsToMany('App\User');
        // return $this->belongsToMany('App\User', 'users_tasks', 'user_id', 'task_id');
        // return $this->belongsToMany(User::class, 'user_id');
    }
}
