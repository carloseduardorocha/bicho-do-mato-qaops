<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     */
    protected $table = 'news';

    /*
    |--------------------------------------------------------------------------
    | Constants
    |--------------------------------------------------------------------------
    */

    public const ID          = 'id';
    public const TITLE       = 'title';
    public const DESCRIPTION = 'description';
    public const AUTHOR_ID   = 'author_id';
    public const IMAGES      = 'images';
    public const CREATED_AT  = 'created_at';
    public const UPDATED_AT  = 'updated_at';
    public const DELETED_AT  = 'deleted_at';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        self::TITLE,
        self::DESCRIPTION,
        self::AUTHOR_ID,
        self::IMAGES,
    ];
}
