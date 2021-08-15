<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use \DateTimeInterface;

class UserProfile extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia, HasFactory;

    public $table = 'user_profiles';

    protected $appends = [
        'image',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'crops' => 'array',
    ];

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'mobile',
        'secondary_mobile',
        'agricultural_land',
        'crops',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }


    public static function createProfile($array)
    {
        $without = Arr::except($array, ['crops']);
        $crops = ['crops'=>$array['crops']];
        $store = array_merge($without,$crops);
        return UserProfile::create($store);
    }

    public  function updateProfile($array)
    {
        $without = Arr::except($array, ['crops']);
        $crops = ['crops'=>json_encode($array['crops'])];
        $update = array_merge($without,$crops);
        return $this->where(['user_id'=>$array['user_id']])->update($update);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id','id');
    }

    public function getImageAttribute()
    {
        $file = $this->getMedia('image')->last();

        if ($file) {
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
            $file->preview   = $file->getUrl('preview');
        }

        return $file;
    }
}
