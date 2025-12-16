<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $fillable = [
            'question',
            'image',
            'video',
            'level',
            'duration',
            'total_grade',
            'passing_grade',
            'user_id',
            'exam_id',
            'course_id'
        ];

        public function course(){
            return $this->belongsTo(Course::class);
        }
        
        public function answers(){
            return $this->hasMany(Answer::class);
        }

}
