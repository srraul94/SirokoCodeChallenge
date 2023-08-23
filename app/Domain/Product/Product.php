<?php

namespace App\Domain\Product;

use App\Domain\Product\ValueObjects\Price;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $table = 'products';
    protected $fillable = ['name', 'price'];


    protected $casts = [
        'price' => 'decimal:2', // Define la precisión de decimales en el precio
    ];


    public function getProductImageAttribute(){

        $nameIMG = $this->id . '.jpeg';

        return asset('img'.DIRECTORY_SEPARATOR.$nameIMG);
    }
}
