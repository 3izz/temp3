<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'language',
        'level',
        'duration',
        'price',
        'category',
        'thumbnail',
        'status',
        'content',
        'projects',
        'objectives',
        'instructor_id',
    ];

    public function instructor(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function students(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class, 'course_user')->withPivot('enrolled_at', 'pricing_plan_id');
    }

    public function pricingPlans(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(PricingPlan::class, 'course_pricing_plan');
    }
}
