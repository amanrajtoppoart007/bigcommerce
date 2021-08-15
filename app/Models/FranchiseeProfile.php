<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use \DateTimeInterface;

class FranchiseeProfile extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia, Auditable, HasFactory;

    public $table = 'franchisee_profiles';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $appends = [
        'image',
        'aadhaar_card',
        'pan_card',
        'address_proof',
        'signature',
    ];

    const PAYMENT_METHOD_RADIO = [
        'CASH'   => 'Cash',
        'CHEQUE' => 'Cheque',
        'RTGS'   => 'RTGS',
        'DD'     => 'DD in Favour of Company',
        'ONLINE'     => 'Online',
    ];

    protected $fillable = [
        'franchisee_id',
        'organization_name',
        'gst_number',
        'representative_name',
        'representative_designation',
        'email',
        'primary_contact',
        'secondary_contact',
        'work_area',
        'organization_address',
        'organization_street',
        'organization_address_line_two',
        'organization_state_id',
        'organization_district_id',
        'organization_city_id',
        'representative_address',
        'representative_street',
        'representative_address_line_two',
        'representative_state_id',
        'representative_district_id',
        'representative_city_id',
        'registration_fees',
        'payment_method',
        'created_at',
        'updated_at',
        'deleted_at',
        'organization_pincode_id',
        'representative_pincode_id',
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

    public function franchisee()
    {
        return $this->belongsTo(Franchisee::class, 'franchisee_id');
    }

    public function organization_state()
    {
        return $this->belongsTo(State::class, 'organization_state_id');
    }

    public function organization_district()
    {
        return $this->belongsTo(District::class, 'organization_district_id');
    }

    public function organization_city()
    {
        return $this->belongsTo(Block::class, 'organization_city_id', 'id');
    }

    public function representative_state()
    {
        return $this->belongsTo(State::class, 'representative_state_id');
    }

    public function representative_district()
    {
        return $this->belongsTo(District::class, 'representative_district_id');
    }

    public function representative_city()
    {
        return $this->belongsTo(Block::class, 'representative_city_id', 'id');
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

    public function getAadhaarCardAttribute()
    {
        return $this->getMedia('aadhaar_card')->last();
    }

    public function getPanCardAttribute()
    {
        return $this->getMedia('pan_card')->last();
    }

    public function getAddressProofAttribute()
    {
        return $this->getMedia('address_proof')->last();
    }

    public function getSignatureAttribute()
    {
        return $this->getMedia('signature')->last();
    }
}
