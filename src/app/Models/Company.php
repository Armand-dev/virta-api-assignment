<?php

namespace App\Models;

use App\Traits\HasParentSelf;
use App\Traits\HasStations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory, SoftDeletes, HasParentSelf, HasStations;

    protected $guarded = [
        'id'
    ];

    public static function validate(): void
    {
        request()->validate([
            'name' => ['required', 'min:3', 'max:100'],
            'parent_id' => ['nullable', 'exists:App\Models\Company,id'],
        ]);
    }

    public static function store(): self
    {
        return self::create(request()->only('name', 'parent_id'));
    }
}
