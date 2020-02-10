<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use TrueBV\Punycode;
use Log;

/**
 * App\Site
 *
 * @property int $id
 * @property int $user_id
 * @property string $url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $code
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Action[] $actions
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Site newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Site newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Site query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Site whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Site whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Site whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Site whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Site whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Site whereUserId($value)
 * @mixin \Eloquent
 */
class Site extends Model
{
    protected $fillable = ['user_id','url', 'code', ];
    protected $visible  = [
        'id',
        'url',
        'code',
        'created_at'
    ];

    public function getUrlAttribute($value)
    {
        $parsed_url = parse_url($value);
        if( !isset($parsed_url['scheme']) ){
            $value_with_scheme = "http://$value";
            $parsed_url = parse_url($value_with_scheme);
        }
        $punycode = new Punycode();
        $parsed_url['host'] = $punycode->decode( $parsed_url['host'] );
        unset($parsed_url['scheme']);
        return \App\Services\Helpers::unparse_url($parsed_url);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function actions()
    {
        return $this->hasMany(Action::class);
    }
}
