<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\BlogComment
 *
 * @property int $id
 * @property int $user_id
 * @property int $article_id
 * @property string $text
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BlogComment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BlogComment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BlogComment query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BlogComment whereArticleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BlogComment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BlogComment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BlogComment whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BlogComment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BlogComment whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BlogComment withUser()
 * @mixin \Eloquent
 */
class BlogComment extends Model
{
    public function scopeWithUser( $query ){
        return $query
            ->leftJoin('users',   'users.id',        '=', 'blog_comments.user_id')
            ->leftJoin('tgusers', 'tgusers.chat_id', '=', 'users.name')
            ->addSelect(
                'tgusers.first_name as tgusers.first_name',
                'tgusers.last_name  as tgusers.last_name'
            );
    }
}
