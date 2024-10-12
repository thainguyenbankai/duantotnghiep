@extends('admin.main_admin')
@section('title', 'Trang chủ')
@section('content')
<!-- Bảng -->
<div class="mt-8">
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 rounded-lg">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 border-b border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">STT</th>
                    <th class="px-6 py-3 border-b border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Họ & Tên</th>
                    <th class="px-6 py-3 border-b border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Email Tài khoản</th>
                    <th class="px-6 py-3 border-b border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Ngày tạo</th>
                    <th class="px-6 py-3 border-b border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Vai trò</th>
                    <th class="px-6 py-3 border-b border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Chức năng</th>
                </tr>
            </thead>
            <tbody class="text-sm font-medium text-gray-700">
                @foreach($users as $key => $user)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 border-b border-gray-200">{{ $key + 1 }}</td>
                    <td class="px-6 py-4 border-b border-gray-200">{{ $user->name }}</td>
                    <td class="px-6 py-4 border-b border-gray-200">{{ $user->email }}</td>
                    <td class="px-6 py-4 border-b border-gray-200">{{ $user->created_at->format('d / m / Y') }}</td>
                    <td class="px-6 py-4 border-b border-gray-200">{{ $user->status }}</td>
                    <td class="px-6 py-4 border-b border-gray-200">
                        {{-- <form method="POST" action="{{ route('users.updateStatus', $user->id) }}"> --}}
                            @csrf
                            @method('PATCH')
                            <select class="text-red-500 focus:outline-none" name="keyy" onchange="this.form.submit()">
                                <option value="0" {{ $user->keyy == 'show' ? 'selected' : '' }}>Mở</option>
                                <option value="1" {{ $user->keyy == 'hidden' ? 'selected' : '' }}>Khóa</option>


                            </select>
                        </form>
                    </td>
                    
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<br>
<br>
<br>
<br>
@endsection

