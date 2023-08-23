<?php

namespace App\Http\Controllers;

use App\Domain\Cart\Cart;
use App\Domain\Cart\CartProduct;
use App\Domain\Product\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class CartController extends Controller
{

    public function addToCart(Request $request, $productId)
    {

        try {
            DB::beginTransaction();

            $cart = Cart::where('complete',false)->first();
            if (is_null($cart)){
                $cart = new Cart();
                $cart->save();
            }

            DB::commit();

            $product = Product::findOrFail($productId);
            $cart->addItem($product,$request->quantity);

            return response()->json(['message' => 'Product added to cart successfully'],200);

        }
        catch (Exception $e){
            DB::rollBack();
            return response()->json(['message' => 'Error! Product cant be added: '. $e->getMessage()],500);
        }
    }

    public function updateCartItem(Request $request, $productId)
    {
        try {
            $cart = Cart::where('complete',false)->firstOrFail();

            $product = Product::findOrFail($productId);
            $cart->updateItemQuantity($product,$request->quantity);

            return response()->json(['message' => 'Cart item updated successfully'],200);
        }
        catch (\Exception $e){
            DB::rollBack();
            return response()->json(['message' => 'Error! Product cant be updated: '. $e->getMessage(),500]);
        }
    }

    public function removeFromCart($productId)
    {
        try {
            $cart = Cart::where('complete',false)->firstOrFail();

            $product = Product::findOrFail($productId);
            $cart->removeItem($product);

            return response()->json(['message' => 'Cart item deleted successfully'],200);
        }
        catch (\Exception $e){
            DB::rollBack();
            return response()->json(['message' => 'Error! Product cant be deleted: '. $e->getMessage()],500);
        }


    }

    public function confirmCartPurchase()
    {
        try {
            $cart = Cart::where('complete',false)->firstOrFail();

            $cart->update(['complete' => true]);

            return response()->json(['message' => 'Cart purchase confirmed!'],200);
        }
        catch (\Exception $e){
            DB::rollBack();
            return response()->json(['message' => 'Error! Cart purchase cant be confirmed: '. $e->getMessage()],500);
        }
    }

    public function getTotalProductsInCart()
    {
        try {
            $cart = Cart::with('cartProducts')->where('complete',false)->first();

            if (is_null($cart)){
                return response()->json(['products' => 0],200);
            }
            else{
                return response()->json(['products' => $cart->getTotalItems()],200);
            }
        }
        catch (\Exception $e){
            return response()->json(['message' => $e->getMessage(),'products' => 0],500);
        }

    }

    public function cartCheckout(Request $request){

        try {
            $totalPrice = 0;
            $cartProducts = [];
            $cart = Cart::find($request->cart_id);
            if (!is_null($cart)){
                $cartProducts = $cart->cartProducts;
                foreach ($cartProducts as $cartProduct){
                    $totalPrice += $cartProduct->PriceAll;
                }

                return view('cart',compact('cart','cartProducts','totalPrice'));
            }
            else{
               $cart = Cart::where('complete',false)->first();
               if (!is_null($cart)){
                   return view('cart',compact('cart','cartProducts','totalPrice'));
               }
               else{
                   return view('cart-empty',compact('cart','cartProducts','totalPrice'));
               }

            }

        }
        catch (\Exception $e){
            dd($e);
        }
    }



}
