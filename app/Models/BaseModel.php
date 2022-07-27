<?php

namespace App\Models;

use App\Services\System\ImageUploadService;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    use HasFactory;

    protected                 $hidden  = ['translates', 'created_at', 'updated_at', 'deleted_at'];
    public ImageUploadService $imageService;
    public string             $path;

    protected $casts = [
        'translates' => 'object'
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->imageService = new ImageUploadService();
    }

    public function getFillable(): array
    {
        return $this->fillable;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function name(): Attribute
    {
        return new Attribute(
            get: fn($value) => $value ?? helper()->modelTranslate($this->translates, 'name')
        );
    }

    public function photo(): Attribute
    {
        return new Attribute(
            get: fn() => $this->imageService->getPhoto($this->path, $this->photo_path)
        );
    }

    public function scopeActive($q, $active = 1)
    {
        return $q->where('is_active', $active);
    }

    public function scopeNameLike($q, $name)
    {
        return $q->where(function ($q) use ($name) {
            foreach (helper()->languageWithCode() as $lang):
                $q->where('translates->' . $lang . '->name', 'like', '%' . $name . '%');
            endforeach;
        });
    }
}
