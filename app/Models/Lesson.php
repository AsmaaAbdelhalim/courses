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
        'completed'
    ];
    
    
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function User()
    {
        return $this->belongsTo(User::class);
    }


    public function lessons_completed()
    {
        return $this->hasMany(lesson::class, 'user_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'course_user')
        ->withPivot('lessons_completed')
        ->withTimestamps();
    }

    }
           
// public function lesson_files()
    // {
    //     return $this->hasMany(LessonFile::class);
    // }


