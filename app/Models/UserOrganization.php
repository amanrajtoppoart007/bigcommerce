<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use \DateTimeInterface;

class UserOrganization extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia, HasFactory;

    public $table = 'user_organizations';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $appends = [
        'representative_image',
        'aadhaar_card',
        'pan_card',
        'organization_address_proof',
        'signature',
    ];

    protected $fillable = [
        'gst_number',
        'organization_name',
        'representative_name',
        'representative_designation',
        'email',
        'primary_contact',
        'secondary_contact',
        'work_area',
        'amount_deposited_method',
        'amount_deposited',
        'user_id',
        'organization_address',
        'organization_street',
        'organization_address_line_two',
        'organization_district_id',
        'organization_city_id',
        'organization_state_id',
        'organization_pincode',
        'representative_address',
        'representative_street',
        'representative_address_line_two',
        'representative_district_id',
        'representative_city_id',
        'representative_state_id',
        'representative_pincode',
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

    public function getRepresentativeImageAttribute()
    {
        $file = $this->getMedia('representative_image')->last();

        if ($file) {
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
            $file->preview   = $file->getUrl('preview');
        }

        return $file;
    }

    public function getAadhaarCardAttribute()
    {
        return $this->getMedia('aadhaar_card')->last();
    }

    public function getPanCardAttribute()
    {
        return $this->getMedia('pan_card')->last();
    }

    public function getOrganizationAddressProofAttribute()
    {
        return $this->getMedia('organization_address_proof')->last();
    }

    public function getSignatureAttribute()
    {
        $file = $this->getMedia('signature')->last();

        if ($file) {
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
            $file->preview   = $file->getUrl('preview');
        }

        return $file;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function organization_district()
    {
        return $this->belongsTo(District::class, 'organization_district_id');
    }

    public function organization_city()
    {
        return $this->belongsTo(City::class, 'organization_city_id');
    }

    public function organization_state()
    {
        return $this->belongsTo(State::class, 'organization_state_id');
    }

    public function representative_district()
    {
        return $this->belongsTo(District::class, 'representative_district_id');
    }

    public function representative_city()
    {
        return $this->belongsTo(City::class, 'representative_city_id');
    }

    public function representative_state()
    {
        return $this->belongsTo(State::class, 'representative_state_id');
    }
}
