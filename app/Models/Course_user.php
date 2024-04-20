<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course_user extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'course_id', 'lesson_id','create_at', 'update_at','completed  ']; 
    // public function user(){
    //     return $this->belongsTo(User::class);
    // }
    // public function course(){
        
    //     return $this->belongsTo(Course::class);
    // }
    public function lesson(){
        return $this->belongsTo(Lesson::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function courses(){
        return $this->belongsTo(Course::class);
        

    }
}
