<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class accessToken extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'accessTokens';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'access_token';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;
}
