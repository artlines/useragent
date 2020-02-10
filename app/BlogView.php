<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\BlogView
 *
 * @property int $id
 * @property int $user_id
 * @property int $article_id
 * @property string $source
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BlogView newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BlogView newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BlogView query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BlogView whereArticleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BlogView whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BlogView whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BlogView whereSource($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BlogView whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BlogView whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BlogView withTelegramUser()
 * @mixin \Eloquent
 */
class BlogView extends Model
{
    public function scopeWithTelegramUser( $query ){
        return $query
            ->leftJoin('users',   'users.id',        '=', 'blog_views.user_id')
            ->leftJoin('tgusers', 'tgusers.chat_id', '=', 'users.name')
            ->addSelect(
                'tgusers.first_name as tgusers.first_name',
                'tgusers.last_name  as tgusers.last_name'
            );
    }
}
