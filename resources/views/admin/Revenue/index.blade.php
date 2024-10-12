@extends('admin.main_admin')
@section('title', 'Doanh thu')

@section('content')
<div class="container mx-auto mt-10">
    <h2 class="text-3xl font-bold mb-4 text-center text-blue-800">BÁO CÁO DOANH THU</h2>

    <div class="mb-6 flex justify-around items-center">
        <div>
            <h3 class="text-xl font-semibold">Tổng doanh thu: 
                <span class="text-blue-600 text-2xl">500,000 VNĐ</span>
            </h3>
            <h3 class="text-xl font-semibold">Tổng số đơn hàng: 
                <span class="text-blue-600 text-2xl">250</span>
            </h3>
        </div>
        <div class="w-1/3">
            <!-- Vùng chứa biểu đồ doanh thu -->
            <canvas id="revenueChart"></canvas>
        </div>
    </div>

    <div class="overflow-x-auto shadow-lg rounded-lg mt-10">
        <table class="min-w-full bg-white border border-gray-200 rounded-lg">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-6 py-3 border-b text-left text-sm font-bold text-gray-600 uppercase">STT</th>
                    <th class="px-6 py-3 border-b text-left text-sm font-bold text-gray-600 uppercase">Tên sản phẩm</th>
                    <th class="px-6 py-3 border-b text-left text-sm font-bold text-gray-600 uppercase">Số lượng bán</th>
                    <th class="px-6 py-3 border-b text-left text-sm font-bold text-gray-600 uppercase">Doanh thu</th>
                    <th class="px-6 py-3 border-b text-left text-sm font-bold text-gray-600 uppercase">Ngày bán</th>
                </tr>
            </thead>
            <tbody class="text-sm font-medium text-gray-700">
                <tr class="hover:bg-gray-100">
                    <td class="px-6 py-4 border-b">1</td>
                    <td class="px-6 py-4 border-b">Sản phẩm A</td>
                    <td class="px-6 py-4 border-b">100</td>
                    <td class="px-6 py-4 border-b">10,000,000 VNĐ</td>
                    <td class="px-6 py-4 border-b">01/01/2024</td>
                </tr>
                <tr class="hover:bg-gray-100">
                    <td class="px-6 py-4 border-b">2</td>
                    <td class="px-6 py-4 border-b">Sản phẩm B</td>
                    <td class="px-6 py-4 border-b">75</td>
                    <td class="px-6 py-4 border-b">7,500,000 VNĐ</td>
                    <td class="px-6 py-4 border-b">02/01/2024</td>
                </tr>
                <tr class="hover:bg-gray-100">
                    <td class="px-6 py-4 border-b">3</td>
                    <td class="px-6 py-4 border-b">Sản phẩm C</td>
                    <td class="px-6 py-4 border-b">50</td>
                    <td class="px-6 py-4 border-b">100,000</td>
                    
                    <td class="px-6 py-4 border-b">03/01/2024</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const data = {
        labels: ['01/01', '02/01', '03/01'],
        datasets: [{
            label: 'Doanh thu (VNĐ)',
            data: [giatri1, giatri1, giatri1],
            backgroundColor: 'rgba(54, 162, 235, 0.6)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
    };

    // Cấu hình biểu đồ
    const config = {
        type: 'bar',
        data: data,
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    };

    // Vẽ biểu đồ
    const revenueChart = new Chart(
        document.getElementById('revenueChart'),
        config
    );
</script>
@endsection
