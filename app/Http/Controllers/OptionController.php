<?php

namespace App\Http\Controllers;

use App\Models\Options;
use Illuminate\Http\Request;

class OptionController extends Controller
{
    public function index()
    {
        $options = Options::paginate(10);
        return view('admin.Options.index', compact('options'));
    }

    public function create()
    {
        return view('admin.Options.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'ram' => 'required|string|max:225',
            'rom' => 'required|string|max:225',
        ]);

        $data = $request->all();

        options::create($data);

        return redirect()->route('admin.options.index')->with('success', 'Tạo màu sắc thành công !');
    }

    public function edit($id)
    {
        $options = Options::findOrFail($id);
        $ramOptions = ['4', '6', '8', '12', '16'];
        $romOptions = ['32', '64', '128', '256', '512'];

        return view('admin.Options.edit', compact('options', 'ramOptions', 'romOptions'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'ram' => 'required|string|max:225',
            'rom' => 'required|string|max:225',
        ]);

        $options = Options::findOrFail($id);
        $options->update($request->all());

        return redirect()->route('admin.options.index')->with('success', 'Cập nhật màu sắc thành công!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $options = Options::findOrFail($id);
        $options->delete();

        return redirect()->route('admin.options.index')->with('success', 'Xóa màu sắc thành công');
    }

    public function trash_option() {
        $options = Options::onlyTrashed()->paginate(10);
        return view('admin.options.trash', compact('options'));
    }
    public function restore($id) {
        $options = Options::withTrashed()->where('id', $id)->first();
        $options->restore();
        return redirect()->route('admin.trash_options')->with('success', 'Khôi phục màu sắc thành công!');
    }
    public function delete($id) {
        $options = Options::withTrashed()->where('id', $id)->first();
        $options->forceDelete();
        return redirect()->route('admin.trash_options')->with('success', 'Xóa màu sắc vĩnh viễn thành công!');
    }
}
