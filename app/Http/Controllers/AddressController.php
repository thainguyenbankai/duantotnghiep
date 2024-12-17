<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function address() {
        $user_id = Auth::id();
    if ($user_id) {
        $addresses = Address::where('user_id', $user_id)->get();
        return response()->json($addresses, 200);
    }
    return response()->json(['error' => 'Unauthorized'], 401);
    }
    public function add_address(Request $request) {
        $userId = Auth::id();
        if (!$userId) {
            return response()->json(['message' => 'User not authenticated'], 401);
        }
    
        $address = Address::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'street' => $request->street,
            'user_id' => $userId,
        ]);
    
        return response()->json($address, 201);
    }

    public function put_address(Request $request,string $addressid){
        $address = Address::find($addressid);

    if (!$address) {
        return response()->json(['message' => 'Địa chỉ không tồn tại.'], 404);
    }
    $address->name = $request->input('name');
    $address->phone = $request->input('phone');
    $address->street = $request->input('street');
    $address->save();

    return response()->json($address, 200);
    }
}
