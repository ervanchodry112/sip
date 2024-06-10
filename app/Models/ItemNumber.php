<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemNumber extends Model
{
    use HasFactory;

    protected $table = 'item_number';

    protected $fillable = [
        'last_number'
    ];

    public static function getNumber()
    {
        $latest = static::latest()->first();
        if (!empty($latest)) {
            $new = $latest->last_number + 1;
            $latest->update([
                'last_number'   => $new,
            ]);
        } else {
            $new = 1;
            static::create(['last_number' => $new]);
        }
        return $new;
    }
}
