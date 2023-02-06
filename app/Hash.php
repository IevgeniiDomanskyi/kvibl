<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hash extends Model
{
    const TYPE_VERIFY = 'verify_email';
    const TYPE_RECOVERY = 'recovery_password';
    const TYPE_CHANGE_EMAIL = 'change_email';
    const TYPE_ACTIVATE = 'activate_email';

    protected $fillable = [
        'hash',
        'type',
        'expired_at',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleted(function ($model)
        {
            $model->users()->detach();
        });
    }

    public function users()
    {
        return $this->morphedByMany(User::class, 'hashable')->withTimestamps();
    }
}
