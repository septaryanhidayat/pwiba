<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitorLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'ip_address',
        'session_id',
        'url',
        'route_name',
        'method',
        'referrer',
        'referrer_domain',
        'referrer_type',
        'user_agent',
        'device_type',
        'browser',
        'platform',
    ];

    /**
     * Scope for logs created today.
     */
    public function scopeToday(Builder $query): Builder
    {
        return $query->whereDate('created_at', today());
    }

    /**
     * Scope for logs created yesterday.
     */
    public function scopeYesterday(Builder $query): Builder
    {
        return $query->whereDate('created_at', today()->subDay());
    }

    /**
     * Scope for logs created in the last 7 days.
     */
    public function scopeLast7Days(Builder $query): Builder
    {
        return $query->where('created_at', '>=', now()->subDays(7));
    }

    /**
     * Scope for logs created in the last 30 days.
     */
    public function scopeLast30Days(Builder $query): Builder
    {
        return $query->where('created_at', '>=', now()->subDays(30));
    }

    /**
     * Scope for online/active visitors within the last 15 minutes.
     */
    public function scopeOnline(Builder $query): Builder
    {
        return $query->where('created_at', '>=', now()->subMinutes(15));
    }

    /**
     * Anonymized/masked IP address for visitor privacy protection.
     */
    public function getMaskedIpAttribute(): string
    {
        if (! $this->ip_address) {
            return '-';
        }

        if (filter_var($this->ip_address, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            $parts = explode('.', $this->ip_address);
            if (count($parts) === 4) {
                return $parts[0].'.'.$parts[1].'.*.*';
            }
        }

        return substr($this->ip_address, 0, 8).'****';
    }
}
