<?php

namespace App\Domain\Cart;

use App\Domain\Product\Product;
use App\Domain\Product\ValueObjects\Price;
use Illuminate\Database\Eloquent\Model;

class CartProduct extends Model
{
    protected $table = "cart_products";

    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity',
        'product_price_amount'
    ];


    public function product(){
        return $this->hasOne(Product::class,'id','product_id');
    }

    public function updateItemQuantity(Product $product, $newQuantity)
    {
        foreach ($this->items as $item) {
            if ($item->getProduct() === $product) {
                $item->updateQuantity($newQuantity);
                break;
            }
        }
    }

    public function getTotalPrice()
    {
        $totalPrice = new Price(0, $this->items[0]->getProduct()->getPrice()->getCurrency()); // Moneda del primer producto

        foreach ($this->items as $item) {
            $subtotal = $item->getProduct()->getPrice()->multiply($item->getQuantity());
            $totalPrice = $totalPrice->add($subtotal);
        }

        return $totalPrice;
    }

    public function removeItem(Product $product)
    {
        $this->items = array_filter($this->items, function ($item) use ($product) {
            return $item->getProduct() !== $product;
        });
    }

    public function getTotalItems()
    {
        return count($this->items);
    }


    public function getPriceAllAttribute(){

        $price = $this->quantity * $this->product_price_amount ;

        return $price;
    }
}
