<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use OwenIt\Auditing\Auditable as AuditableHelper;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Language extends Model implements AuditableContract
{
    use HasFactory, SoftDeletes, AuditableHelper;

    protected $table = 'languages';
    protected $fillable = [
        'name',
        'code'
    ];

    protected $casts = [
        'name' => 'string',
        'code' => 'string',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saved(function ($language) {
            Cache::forget('appLanguages');
        });

        static::deleted(function ($language) {
            Cache::forget('appLanguages');
        });
    }

    /**
     * @return Attribute
     */
    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: static fn($value) => Carbon::parse($value)->format('Y-m-d h:i A')
        );
    }
}
