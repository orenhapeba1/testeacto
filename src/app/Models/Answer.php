<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\Relations\Relation as EloquentRelation;


class Answer extends Model
{
    use HasFactory;

    protected $fillable = ['form_id', 'question_id', 'token_answer', 'answer','question_json'];

    public function form()
    {
        return $this->belongsTo(Form::class,'form_id');
    }

    public function question()
    {
        return $this->belongsTo(Question::class,'question_id');
    }
    
}
