<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Enquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference_number', 'full_name', 'company_name', 'mobile_number',
        'email', 'category_id', 'product_id', 'product_name', 'quantity',
        'budget_range', 'location', 'message', 'attachment', 'source',
        'status', 'internal_notes', 'assigned_to', 'contacted_at',
    ];

    protected $casts = [
        'contacted_at' => 'datetime',
    ];

    const STATUS_LABELS = [
        'new' => 'New',
        'contacted' => 'Contacted',
        'follow_up' => 'Follow Up',
        'quotation_sent' => 'Quotation Sent',
        'converted' => 'Converted',
        'closed' => 'Closed',
    ];

    const STATUS_COLORS = [
        'new' => 'blue',
        'contacted' => 'yellow',
        'follow_up' => 'orange',
        'quotation_sent' => 'purple',
        'converted' => 'green',
        'closed' => 'gray',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($enquiry) {
            if (empty($enquiry->reference_number)) {
                $enquiry->reference_number = 'ENQ-' . strtoupper(Str::random(8));
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function notes()
    {
        return $this->hasMany(EnquiryNote::class)->latest();
    }

    public function getStatusLabelAttribute()
    {
        return self::STATUS_LABELS[$this->status] ?? $this->status;
    }

    public function getStatusColorAttribute()
    {
        return self::STATUS_COLORS[$this->status] ?? 'gray';
    }

    public function getAttachmentUrlAttribute()
    {
        if ($this->attachment) {
            return asset('storage/' . $this->attachment);
        }
        return null;
    }
}
