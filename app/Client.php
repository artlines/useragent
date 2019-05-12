<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = ['fingerprint'];

    public function actions()
    {
        return $this->hasMany(Action::class, 'fingerprint', 'fingerprint');
    }
}
