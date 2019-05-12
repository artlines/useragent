<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    protected $fillable= ['site_id', 'fingerprint', 'data','action', 'ip','region', 'referer', 'utm'];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'fingerprint','fingerprint');
    }
    
}
