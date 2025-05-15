<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\Relations\Relation as EloquentRelation;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'type', 'options'];

    protected $casts = [
        'options' => 'array',
    ];

    public function forms()
    {
        return $this->belongsToMany(Form::class, 'form_questions');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
