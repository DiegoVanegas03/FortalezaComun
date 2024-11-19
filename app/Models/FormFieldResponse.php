<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormFieldResponse extends Model
{
    use HasFactory;
    protected $fillable = ['form_response_id', 'form_field_id', 'value'];

    public function field()
    {
        return $this->belongsTo(FormField::class);
    }

    public function response()
    {
        return $this->belongsTo(FormResponse::class);
    }
}
