<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LaData extends Model
{
    const AVG_2018_GROWTH = 0.055435736;
    const AVG_2017_GROWTH = 0.055435736;
    const AVG_2016_GROWTH = 0.055435736;

    protected $table = 'la_data';
}
