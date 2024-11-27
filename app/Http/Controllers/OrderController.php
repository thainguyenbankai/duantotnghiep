<?php

namespace App\Http\Controllers;

use App\Models\OrderStatus;
use App\Models\OrderUser;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = OrderUser::all();
        $statuses = OrderStatus::all();
        return view('admin.Order.index', compact('orders', 'statuses'));
    }
    public function updateStatus(Request $request, $id)
    {   
        $user = OrderUser::findOrFail($id);
        $user->status_id = $request->input('status_id');
        $user->save();

        return redirect()->route('admin.orders.index')->with('success', 'Trạng thái người dùng đã được cập nhật.');
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
