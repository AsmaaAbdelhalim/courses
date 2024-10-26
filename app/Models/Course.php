<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Support\Facades\Auth;
class Course extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
    'code',
    'description',
    'summary',
    'requirement',
    'price',
    'discount',
    'numOfHours',
    'started_at',
    'finished_at',
    'duration',
    'image',
    'files',
    'videos',
    'status',
    'level',
    'teachers',
    'language',
    'category_id',
    'user_id',
    ];


    public function user(){
        return $this->belongsTo(User::class);
    }
  
        public function enrollment()
        {
            return $this->hasMany(Enrollment::class);
        }
        
        public function isEnrolledByUser(User $user)
        {
            return $this->enrollment()->where('user_id', $user->id)->exists();
        }
        public function category(){
            return $this->belongsTo(Category::class);
        }
 

    public function lesson(){
        return $this->hasMany(Lesson::class);
    }

    public function lessons(){
        return $this->hasMany(Lesson::class);
    }
    public function reviews()
{
    return $this->hasMany(Review::class);
}
public function wishlists()
{
    return $this->hasMany(Wishlist::class);
}


public function users()
{
    return $this->belongsToMany(User::class, 'course_users')->withPivot('completed');
}

public function teachers()
{
    return $this->belongsToMany(User::class, 'courses','teachers', 'user_id','user_role'

);
}

public function payments()
{
    return $this->hasMany(Payment::class);
}

public function questions()
    {
        return $this->hasMany(Question::class);
    }

public function exams()
    {
        return $this->hasMany(Exam::class);
    }


}
