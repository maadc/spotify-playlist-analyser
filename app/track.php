<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class track extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'top-tracks';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'spotifyID';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
