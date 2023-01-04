<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price'
    ];

    public static function createRules($merge=[]) {
        return array_merge(
            [
                'name' => 'required|string|max:255|unique:products',
                'slug' => 'required|string|max:255|unique:products',
                'description' => 'required|string',
                'price' => 'required|decimal:2'
            ], $merge
        );
    }

    public static function updateRules($id, $merge=[]) {
        return array_merge(
            [
                'name' => 'required|string|max:255|unique:products,name,'.$id,
                'slug' => 'required|string|max:255|unique:products,slug,'.$id,
                'description' => 'required|string',
                'price' => 'required|decimal:2'
            ], $merge
        );
    }
}
