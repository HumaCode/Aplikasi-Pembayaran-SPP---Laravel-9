<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;


class WaliBank extends Model
{
    use HasFactory;
    protected $append = ['nama_bank_full'];


    protected $guarded = [];

    /**
     * Get the user's first name.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function namaBankFull(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->nama_bank . ' - An. ' . $this->nama_rekening . ' (' . $this->nomor_rekening . ') ',
        );
    }
}
