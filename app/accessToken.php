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
    protected $table = 'access_tokens';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'access_token';
    protected $keyType = 'string';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * fields which are allowed to be mass-assigned
     */
    protected $fillable = ['access_token', 'expires', 'created_at', 'uses'];
}
