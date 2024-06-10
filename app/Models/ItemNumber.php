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
        $new = $latest->last_number + 1;
        if (!empty($latest)) {
            $latest->update([
                'last_number'   => $new,
            ]);
        } else {
            static::create(['last_number' => 1]);
        }
        return $new;
    }
}
