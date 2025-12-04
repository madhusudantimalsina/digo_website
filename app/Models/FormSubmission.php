<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormSubmission extends Model
{
    protected $fillable = [
        'form_id',
        'full_name',
        'email',
        'message',
        'extra_data',
        'status',
    ];

    protected $casts = [
        'extra_data' => 'array',
    ];

    public function form()
    {
        return $this->belongsTo(Form::class);
    }
}
