<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $table = 'questions';

    public function options() {
        return $this->hasMany(related: Option::class, foreignKey: 'question_id', localKey: 'id');
    }
}
