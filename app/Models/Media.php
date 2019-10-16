<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Relations\BelongsToUser;

class Media extends Model
{
    use BelongsToUser;
    
    const TYPE_IMAGE = 'image';
    const TYPE_VIDEO = 'video';
    const TYPE_FILE = 'file';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'mediable_type',
        'mediable_id',
        'name',
        'path',
        'extension',
        'type',
        'mime_type',
        'size',
        'preview_path',
        'width',
        'height',
    ];

    protected static function boot()
    {
        parent::boot();
        self::saving(function ($media) {
            if (Auth::check() && !$media->user_id) {
                $media->user_id = Auth::id();
            }
        });
    }
    /**
     * Get the mediable that owns the media.
     */
    public function mediable()
    {
        return $this->morphTo();
    }

    /**
     * Get the url for the media.
     */
    public function getUrlAttribute()
    {
        return storage_url($this->attributes['path']);
    }

    /**
     * Get preview url for the media
     * @return mixed
     */
    public function getPreviewUrlAttribute()
    {
        return storage_url(array_get($this->attributes, 'preview_path'));
    }

    public function getDateFormatAttribute()
    {
        return preg_replace('/[-: ]/', '', $this->created_at);
    }
}