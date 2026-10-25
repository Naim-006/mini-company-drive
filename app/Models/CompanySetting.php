<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanySetting extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'company_name',
        'tagline',
        'email',
        'phone',
        'address',
        'about_summary',
        'about_mission',
        'about_vision',
        'opening_hours',
    ];

    /**
     * Get or create the primary company settings singleton row.
     */
    public static function current(): self
    {
        return static::firstOrCreate(
            ['id' => 1],
            [
                'company_name' => 'Mini Company Inc.',
                'tagline' => 'Innovative solutions for growing businesses',
                'email' => 'contact@minicompany.test',
                'phone' => '+1 (555) 123-4567',
                'address' => '100 Innovation Way, Suite 400, Tech City, TC 10101',
                'about_summary' => 'Mini Company Inc. is dedicated to providing high-quality digital products and consulting services to modern enterprises.',
                'about_mission' => 'Empowering businesses through cutting-edge technology and exceptional customer support.',
                'about_vision' => 'To become the most reliable business and software partner for small and medium enterprises worldwide.',
                'opening_hours' => 'Monday - Friday: 9:00 AM - 6:00 PM EST',
            ]
        );
    }
}
