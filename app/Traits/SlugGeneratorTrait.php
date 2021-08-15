<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait SlugGeneratorTrait{

    private $slugCounter = 0;

    public function generateSlug($model, $title, $slug = null, $exceptId = null)
    {
        if (!isset($slug)) {
            $slug = Str::slug($title, '-');
        }
        if ($model::where('id', '!=', $exceptId)->whereSlug($slug)->exists()) {
            $slug = Str::slug($title, '-') . (++$this->slugCounter);
            return $this->generateSlug($model, $title, $slug, $exceptId);
        }
        return $slug;
    }

}
