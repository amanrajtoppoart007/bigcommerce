<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticleLikeResource extends JsonResource
{
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
