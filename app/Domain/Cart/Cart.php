<?php

namespace App\Domain\Cart;

use App\Domain\Product\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class Cart extends Model
{

    protected $fillable = [
        'complete'
    ];

    public function cartProducts()
    {
        return $this->hasMany(CartProduct::class);
    }


    public function addItem(Product $product, $quantity)
    {
        try {
            DB::beginTransaction();

            $cartProduct = CartProduct::where('product_id', $product->id)->where('cart_id', $this->id)->first();
            if (is_null($cartProduct)) {
                CartProduct::create([
                    'cart_id' => $this->id,
                    'product_id' => $product->id,
                    'product_price_amount' => $product->price,
                    'quantity' => $quantity
                ]);
            } else {
                $cartProduct->update([
                    'quantity' => $cartProduct->quantity + $quantity
                ]);
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
        }
    }

    public function updateItemQuantity(Product $product, $newQuantity)
    {
        try {
            DB::beginTransaction();

            $cartProduct = CartProduct::where('product_id', $product->id)->where('cart_id', $this->id)->firstOrFail();

            if ($newQuantity != 0) {
                $cartProduct->update([
                    'quantity' => $newQuantity
                ]);
            } else {
                $this->removeItem($product);
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
        }
    }

    public function removeItem(Product $product)
    {
        try {
            DB::beginTransaction();

            $cartProduct = CartProduct::where('product_id', $product->id)->where('cart_id', $this->id)->firstOrFail();
            $cartProduct->delete();

            DB::commit();

        } catch (Exception $e) {
            DB::rollBack();
        }
    }

    public function getTotalItems()
    {
        return sizeof($this->cartProducts);
    }
}
