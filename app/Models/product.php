<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Product extends Model
{
    use HasFactory;

    // Properti untuk melindungi kolom yang dapat diisi
    protected $fillable = [
        'title',
        'price',
        'product_code',
        'description'
    ];

    // Aksesori untuk memformat harga sebelum ditampilkan
    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    // Mutator untuk memastikan harga disimpan dalam format angka yang benar
    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = floatval(str_replace(['.', ','], ['', '.'], $value));
    }

    // Contoh validasi untuk produk baru atau saat memperbarui produk
    public static function validate(array $data)
    {
        return Validator::make($data, [
            'title' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'product_code' => 'required|string|unique:products,product_code',
            'description' => 'nullable|string',
        ]);
    }
}
