<?php

namespace App\Models;

use Illuminate\{Database\Eloquent\Casts\Attribute,
    Database\Eloquent\Factories\HasFactory,
    Database\Eloquent\Model,
    Database\Eloquent\Relations\BelongsTo,
    Database\Eloquent\SoftDeletes,
    Support\Facades\Storage,
    Support\Str};
use OwenIt\Auditing\Auditable as AuditableHelper;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use Spatie\Translatable\HasTranslations;

class Product extends Model implements AuditableContract
{
    use HasFactory, SoftDeletes,HasTranslations, AuditableHelper;

    protected $table = 'products';

    public $translatable = [
        'name',
        'description',
    ];

    protected $fillable = [
        'name',
        'price',
        'quantity',
        'category_id',
        'description',
        'image',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'name' => 'string',
        'price' => 'float',
        'quantity' => 'int',
        'category_id' => 'int',
        'description' => 'string',
        'image' => 'string',
        'created_by' => 'int',
        'updated_by' => 'int'
    ];

    /**
     * @return void
     */
    public static function boot(): void
    {
        parent::boot();

        static::saving(function ($product) {
            if (request()->hasFile('image')) {
                $product->uploadImage(request()->file('image'));
            }
        });
    }

    /**
     * @param $image
     * @return void
     */
    public function uploadImage($image): void
    {
        $path = $image->store('products', 'public');
        $this->image = url('storage/' . $path);
    }

    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(related: Category::class);
    }

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->getImageUrl($value)
        );
    }

    /**
     * @param string|null $value
     * @return string|null
     */
    protected function getImageUrl(?string $value): ?string
    {
        if (!empty($value)) {
            if (preg_match('#^https?://#', $value)) {
                return $value;
            }
            return url('public')->url($value);
        }

        return null;
    }
}
