<?php

namespace App\Models\Traits\Relations;

use App\Models\Media;

trait HasMedia
{
    /**
     * Get the media for the object.
     */
    public function media()
    {
        return $this->morphMany(Media::class, 'mediable');
    }
}
