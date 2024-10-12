<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $query = Supplier::join('users', 'suppliers.user_id', '=', 'users.id')
            ->select('suppliers.*', 'users.status as status');

        if ($search) {
            $suppliers = $query->where('suppliers.name', 'like', "%{$search}%")->paginate(10);
            $request->session()->flash('search', $suppliers->total());  // Lưu kết quả tìm kiếm vào session
        } else {
            $suppliers = $query->paginate(10);
        }

        return view('admin.Supplier.index', compact('suppliers'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.Supplier.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:225',
            'description' => 'required|string|max:255',
        ]);
        $data = $request->all();
        $data['user_id'] = Auth::id();
        Supplier::create($data);
        return redirect()->route('admin.suppliers.index')->with('success', 'Nhà cung cấp được tạo thành công !');
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
        $supplier = Supplier::findOrFail($id);
        return view('admin.Supplier.edit', compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:225',
            'description' => 'required|string|max:255',
        ]);
        $suppliers = Supplier::findorFail($id);
        $suppliers->update($request->all());
        return redirect()->route('admin.suppliers.index')->with('success', 'Nhà cung cấp đã được cập nhật thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $suppliers =  Supplier::finorFail($id);
        $suppliers->delete();
        return redirect()->route('admin.suppliers.index')->with('success', 'Nhà cung cấp đã được xóa thành công!');
    }
}
