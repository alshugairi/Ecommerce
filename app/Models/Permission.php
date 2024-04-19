<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\{Auditing\Auditable as AuditableHelper, Auditing\Contracts\Auditable as AuditableContract};
use Spatie\Permission\Models\Permission as PermissionModel;

class Permission extends PermissionModel implements AuditableContract
{
    use HasFactory, AuditableHelper;

    protected $fillable = [
        'name',
        'guard_name'
    ];

    protected $casts = [
        'id' => 'int',
        'name' => 'string',
        'guard_name' => 'string',
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

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
