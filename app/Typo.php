<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Typo extends Model
{
    /**
     * Get Typo parent Project.
     */
    public function project()
    {
        return $this->belongsTo('App\Project');
    }
}
