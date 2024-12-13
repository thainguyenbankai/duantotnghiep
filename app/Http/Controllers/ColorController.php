<?php

namespace App\Http\Controllers;

use App\Models\Colors;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ColorController extends Controller
{
    public function index()
    {
        $colors = Colors::paginate(10);
        return view('admin.Colors.index', compact('colors'));
    }

    public function create()
    {
        return view('admin.Colors.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:225',
        ]);

        $data = $request->all();

        Colors::create($data);

        return redirect()->route('admin.colors.index')->with('success', 'Tạo màu sắc thành công !');
    }

    public function edit($id)
    {
        $colors = Colors::findOrFail($id);
        return view('admin.Colors.edit', compact('colors'));
    }
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:225',
            'description' => 'nullable|string|max:255',
        ]);

        $colors = Colors::findOrFail($id);
        $colors->update($request->all());

        return redirect()->route('admin.colors.index')->with('success', 'Cập nhật màu sắc thành công!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $colors = Colors::findOrFail($id);
        $colors->delete();

        return redirect()->route('admin.colors.index')->with('success', 'Xóa màu sắc thành công');
    }
    public function trash_colors() {
        $colors = Colors::onlyTrashed()->paginate(10);
        return view('admin.colors.trash', compact('colors'));
    }
    public function restore($id) {
        $color = Colors::withTrashed()->where('id', $id)->first();
        $color->restore();
        return redirect()->back()->with('success', 'Khôi phục màu sắc thành công!');
    }
    public function deletePermanently($id) {
        $color = Colors::withTrashed()->where('id', $id)->first();
        $color->forceDelete();
        return redirect()->back()->with('success', 'Xóa màu sắc vĩnh viễn thành công!');
    }
}
