<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Station extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [
        'id'
    ];

    public static function validate(): void
    {
        request()->validate([
            'name' => ['required', 'min:3', 'max:100'],
            'latitude' => ['required', 'numeric', /*'between:-90,90'*/],
            'longitude' => ['required', 'numeric', /*'between:-180,180'*/],
//            'lat' => ['required','regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'],
//            'long' => ['required','regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'],
            'company_id' => ['required', 'exists:App\Models\Company,id'],
            'address' => ['required', 'min:3', 'max:100'],
        ]);
    }

    public static function store(): self
    {
        return self::create(request()->only('name', 'latitude', 'longitude', 'company_id', 'address'));
    }

    /**
     * BEGIN: Relationships
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    /**
     * END: Relationships
     */
}
