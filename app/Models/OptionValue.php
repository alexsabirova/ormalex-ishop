<?php

namespace App\Models;

use Database\Factories\OptionValueFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OptionValue extends Model
{
    /** @use HasFactory<OptionValueFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'option_id',
    ];

    public function option(): BelongsTo
    {
        return $this->belongsTo(Option::class);
    }
}
