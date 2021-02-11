<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;

class BaseModel extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_by = Auth::user()->username;
            $model->updated_by = Auth::user()->username;
        });

        static::updating(function ($model) {
            $model->updated_by = Auth::user()->username;
        });
    }
}
