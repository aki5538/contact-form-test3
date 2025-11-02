<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'gender',
        'email',
        'tel',
        'address',
        'building',
        'message',
        'category_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getNameAttribute()
    {
        return $this->last_name . ' ' . $this->first_name;
    }

    public function getGenderLabelAttribute()
    {
        return match ((int) $this->gender) {
            1 => '男性',
            2 => '女性',
            3 => 'その他',
        };
    }

    public function getContactTypeAttribute()
    {
        return optional($this->category)->name;
    }

}
