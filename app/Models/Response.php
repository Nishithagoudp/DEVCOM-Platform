<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    use HasFactory;
    protected $fillable = ['body', 'discussion_id', 'user_id', 'code_snippet'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function discussion()
    {
        return $this->belongsTo(Discussion::class);
    }
    public function parent()
    {
        return $this->belongsTo(Response::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Response::class, 'parent_id');
    }
}
