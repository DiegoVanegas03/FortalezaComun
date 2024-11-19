<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormField extends Model
{
    use HasFactory;
    protected $fillable = ['form_id', 'label', 'type', 'options', 'required'];

    protected $casts = [
        'options' => 'array',  // Si las opciones son un array (para selects o radios)
    ];

    public function form()
    {
        return $this->belongsTo(Form::class);
    }
}
