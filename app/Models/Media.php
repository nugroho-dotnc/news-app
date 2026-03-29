<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable = ['article_id', 'path', 'type'];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
