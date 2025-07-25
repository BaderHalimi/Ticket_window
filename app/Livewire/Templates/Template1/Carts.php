<?php

namespace App\Livewire\Templates\Template1;

use Livewire\Component;
use App\Models\Cart;
use App\Models\Merchant\Branch;
use App\Models\PaidReservation;
use Illuminate\Support\Facades\Auth;
class Carts extends Component
{
    public $user;
    public $carts;
    public function mount(){
        $this->user = Auth::guard('customer')->user();
        if (!$this->user) {
            return redirect()->route('customer.login');
        }
        $this->carts = $this->user->carts;
        //dd($this->user);

    }
    public function checkout_all(){
        foreach ($this->carts as $cart) {
            $this->checkout($cart->id);
        }
        $this->carts = $this->user->carts()->get();

    }
    public function checkout($id){
        $cart = Cart::find($id);
        //dd($cart);
        if(can_booking_now($cart->item_id,$cart->additional_data['branch'])){
            $res = PaidReservation::create([
                'item_id' => $cart->item_id,
                'item_type' => $cart->item_type,
                'user_id' => $this->user->id,
                'quantity' => $cart->quantity,
                'price' => $cart->price,
                'discount' => $cart->discount,
                //'final_price' => $item->price - $item->discount,
                'code' => uniqid('code_'),
                'additional_data' => json_encode($cart->additional_data),
            ]);
            $oldData = json_decode($item->additional_data ?? '{}', true) ?? [];
            $newData = [
                'recipient_id' => $cart->user_id,
                'notes' => 'تم الدفع بنجاح',
                'type' => 'pay',
                'withdrawal' => false,
                'status' => 'pending',
            ];

            $merged = array_merge($oldData, $newData);
            logPayment([
                'user_id' => $this->user->id,
                'item_id' => $cart->offering->id,
                'transaction_id' => uniqid('TXN_'),
                'payment_method' => 'paypal',
                'amount' => $cart->price,
                'additional_data' => $merged,
            ]);
            notifcate(
                $cart->offering->user_id,
                $this->user->f_name . ' قام بالدفع بنجاح',
                'تم الدفع بنجاح للعرض: ' . $cart->offering->name,
                [
                    'type' => 'payment',
                    'offering_id' => $cart->offering->id,

                ],
            );

            notifcate(
                $this->user->id,
                'تم الدفع بنجاح',
                'تم الدفع بنجاح للعرض: ' . $cart->offering->name,
                [
                    'type' => 'payment',
                    'offering_id' => $cart->offering->id,

                ],
            );
            $cart->delete();
            $this->carts = $this->user->carts()->get();


        }

    }
    public function delete($id){
        $cart = Cart::find($id);

        if ($cart) {
            $cart->delete();
            $this->carts = $this->user->carts()->get();

            return response()->json(['message' => 'Deleted successfully']);
        } else {
            return response()->json(['message' => 'Cart not found'], 404);
        }
    }


    public function render()
    {
        return view('livewire.templates.template1.carts');
    }
}
