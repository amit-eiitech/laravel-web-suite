<?php

namespace Eii\WebSuite\Models\Concerns;

use Eii\WebSuite\Models\SeoMetadata;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait HasSeoMetadata
{
    public static function bootHasSeoMetadata(): void
    {
        static::created(function (Model $model) {
            $model->seoMetadata()->firstOrCreate([]);
        });
    }

    public function seoMetadata(): MorphOne
    {
        return $this->morphOne(SeoMetadata::class, 'seoable');
    }
}
