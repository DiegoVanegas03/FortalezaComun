<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description'];

    public function fields()
    {
        return $this->hasMany(FormField::class);
    }

    public function fieldsCount()
    {
        return $this->fields()->count();
    }

    public function responses()
    {
        return $this->hasMany(FormResponse::class);
    }

    public function responsesCount()
    {
        return $this->responses()->count();
    }
}
