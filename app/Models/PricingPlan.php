<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PricingPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'max_courses', // Add max_courses to fillable fields
        'target_type',
        'delivery_mode',
        'schedule_type',
        'is_popular',
    ];

    protected function casts(): array
    {
        return [
            'is_popular' => 'boolean',
            'price' => 'decimal:2',
        ];
    }

    public function courses(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'course_pricing_plan');
    }
}
