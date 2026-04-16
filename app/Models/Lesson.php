<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'course_id',
        'user_id',
        'videos',
        'completed'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function next()
    {
        return self::where('course_id', $this->course_id)
            ->where('id', '>', $this->id)
            ->orderBy('id', 'asc')
            ->first();
    }

    public function previous()
    {
        return self::where('course_id', $this->course_id)
            ->where('id', '<', $this->id)
            ->orderBy('id', 'desc')
            ->first();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}