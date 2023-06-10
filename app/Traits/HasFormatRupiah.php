<?php

namespace App\Traits;

trait HasFormatRupiah
{
    function format_rupiah($field, $prefix = null)
    {
        $prefix  = $prefix ? $prefix : 'Rp. ';
        return $prefix . number_format($this->attributes[$field], 0, ',', '.');
    }
}
