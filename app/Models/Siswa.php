<?php

namespace App\Models;

use App\Http\Middleware\Wali;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Nicolaslopezj\Searchable\SearchableTrait;
use Spatie\ModelStatus\HasStatuses;

class Siswa extends Model
{
    use HasFactory;
    use SearchableTrait;
    use HasStatuses;

    protected $guarded = [];
    protected $searchable = [
        /**
         * Columns and their priority in search results.
         * Columns with higher values are more important.
         * Columns with equal values have equal importance.
         *
         * @var array
         */
        'columns' => [
            'nama' => 10,
            'nisn' => 10,
        ],
    ];

    /**
     * Get the biaya that owns the Siswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function biaya(): BelongsTo
    {
        return $this->belongsTo(Biaya::class);
    }

    /**
     * Get the user that owns the Siswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the wali that owns the Siswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function wali(): BelongsTo
    {
        return $this->belongsTo(User::class, 'wali_id')->withDefault([
            // 'name' => '<span class"text-danger"><b>Belum dilengkapi</b></span>',
            'name' => 'Belum dilengkapi',
        ]);
    }

    /**
     * Get all of the tagihan for the Siswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tagihan(): HasMany
    {
        return $this->hasMany(Tagihan::class);
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        // menambahkkan secara otomatis id user yang login
        static::creating(function ($siswa) {
            $siswa->user_id = auth()->user()->id;
        });

        static::created(function ($siswa) {
            $siswa->setStatus('aktif');
        });

        static::updating(function ($siswa) {
            $siswa->user_id = auth()->user()->id;
        });
    }
}
