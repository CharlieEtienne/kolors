<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    /**
     * Get Color parent Palette.
     */
    public function palette()
    {
        return $this->belongsTo('App\Palette');
    }
}
