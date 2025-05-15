<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Form extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'locked'];

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'form_questions');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
