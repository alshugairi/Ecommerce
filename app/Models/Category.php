<?php

namespace App\Models;

use Illuminate\{Database\Eloquent\Factories\HasFactory, Database\Eloquent\Model, Database\Eloquent\SoftDeletes};
use OwenIt\Auditing\Auditable as AuditableHelper;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use Spatie\Translatable\HasTranslations;

class Category extends Model implements AuditableContract
{
    use HasFactory, SoftDeletes, HasTranslations, AuditableHelper;

    protected $table = 'categories';

    public $translatable = [
        'name',
    ];

    protected $fillable = [
        'name',
        'image',
        'status',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'name' => 'string',
        'image' => 'string',
        'status' => 'int',
        'created_by' => 'int',
        'updated_by' => 'int'
    ];

    /**
     * @return array
     */
    public static function getAll(): array
    {
        $categories = [];
        $data = self::get();
        foreach ($data as $category) {
            $categories[$category->id] = ucfirst($category->name);
        }
        return $categories;
    }
}
