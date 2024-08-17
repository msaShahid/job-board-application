<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Work extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'company', 'location', 'salary','user_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function appliedUser(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'job_applications')
                    ->withPivot('status')
                    ->withTimestamps();
    }
}
