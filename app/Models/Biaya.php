<?php

namespace App\Models;

use App\Traits\HasFormatRupiah;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Biaya extends Model
{
    use HasFactory, HasFormatRupiah;

    protected $guarded = [];
    protected $append = ['nama_biaya_full', 'total_tagihan'];

    /**
     * Get all of the childern for the Biaya
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function childern(): HasMany
    {
        return $this->hasMany(Biaya::class, 'parent_id');
    }

    /**
     * Get the user's first name.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function namaBiayaFull(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->nama . ' - ' . $this->format_rupiah('jumlah'),
        );
    }

    /**
     * Get the user's first name.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function totalTagihan(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->childern()->sum('jumlah'),
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        // menambahkkan secara otomatis id user yang login
        static::creating(function ($biaya) {
            $biaya->user_id = auth()->user()->id;
        });

        static::updating(function ($biaya) {
            $biaya->user_id = auth()->user()->id;
        });
    }

    /**
     * Get all of the siswa for the Biaya
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function siswa(): HasMany
    {
        return $this->hasMany(Siswa::class);
    }
}
