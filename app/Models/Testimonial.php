<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Testimonial extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     */
    protected $table = 'testimonials';

    /*
    |--------------------------------------------------------------------------
    | Constants
    |--------------------------------------------------------------------------
    */

    public const ID = 'id';

    public const NAME = 'name';

    public const DESCRIPTION = 'description';

    public const IMAGE = 'image';

    public const IS_APPROVED = 'is_approved';

    public const CREATED_AT = 'created_at';

    public const UPDATED_AT = 'updated_at';

    public const DELETED_AT = 'deleted_at';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        self::NAME,
        self::DESCRIPTION,
        self::IMAGE,
        self::IS_APPROVED,
    ];
}
