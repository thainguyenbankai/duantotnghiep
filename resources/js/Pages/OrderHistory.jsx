import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { Button, message } from 'antd';
import { DownOutlined } from '@ant-design/icons';
import { Link } from 'react-router-dom';

const OrderHistory = () => {
  const [loading, setLoading] = useState(true);
  const [orders, setOrders] = useState([]);
  const [error, setError] = useState(null);
  const [openDropdown, setOpenDropdown] = useState(null);

  // Format ngày giờ
  const formatDate = (dateString) => {
    const date = new Date(dateString);
    return date.toISOString().split('T')[0];
  };

  // Toggle dropdown (nếu cần)
  const toggleDropdown = (orderId) => {
    setOpenDropdown(openDropdown === orderId ? null : orderId);
  };

  // Gọi API để hủy đơn hàng
  const cancelOrder = async (orderId) => {
    try {
      const response = await axios.delete(`/api/orders/${orderId}`);
      if (response.status === 200) {
        message.success('Đơn hàng đã được hủy thành công');
        // Cập nhật lại danh sách đơn hàng sau khi hủy
        setOrders(orders.filter(order => order.id !== orderId));
      } else {
        message.error('Không thể hủy đơn hàng');
      }
    } catch (error) {
      message.error('Đã xảy ra lỗi, vui lòng thử lại sau.');
    }
  };

  // Lấy danh sách đơn hàng từ API
  useEffect(() => {
    const fetchOrders = async () => {
      try {
        const response = await axios.get('/api/orders/history');
        if (response.status === 200) {
          setOrders(response.data.orders);
          setLoading(false);
        } else {
          setError('Không thể tải đơn hàng.');
          setLoading(false);
        }
      } catch (error) {
        setError('Đã xảy ra lỗi khi tải đơn hàng.');
        setLoading(false);
      }
    };
    
    fetchOrders();
  }, []);

  // Nếu đang tải dữ liệu
  if (loading) {
    return <div className="text-center mt-10">Loading...</div>;
  }

  // Nếu có lỗi khi tải dữ liệu
  if (error) {
    return <div className="text-red-500 text-center mt-10">Error: {error}</div>;
  }

  return (
    <div className="relative overflow-x-auto shadow-md sm:rounded-lg mt-6 sm:mt-8 container mx-auto px-4 sm:px-6 lg:px-8">
      <table className="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
          <tr>
            <th scope="col" className="px-6 py-3">Mã đơn hàng</th>
            <th scope="col" className="px-6 py-3">Tổng đơn hàng</th>
            <th scope="col" className="px-6 py-3">Trạng thái</th>
            <th scope="col" className="px-6 py-3">Ngày lên đơn</th>
            <th scope="col" className="px-6 py-3">Hành động</th>
          </tr>
        </thead>
        <tbody>
          {orders.map((order) => (
            <tr key={order.id} className="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
              <td className="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                {order.id}
              </td>
              <td className="px-6 py-4 text-green-600 dark:text-green-400">
                ${order.total_amount}
              </td>
              <td className="px-6 py-4 inline-flex items-center px-3 py-1 rounded-full bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300">
                {order.name_status}
              </td>
              <td className="px-6 py-4 text-gray-900 dark:text-white">
                {formatDate(order.created_at)}
              </td>
              <td className="px-6 py-4">
                <Button
                  type="danger"
                  className="w-full sm:w-auto bg-red-600 hover:bg-red-700 text-white border-red-600 border-2 hover:border-red-700 transition-all duration-300 mb-2"
                  onClick={() => cancelOrder(order.id)}
                >
                  Hủy đơn hàng
                </Button>
              </td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
};

export default OrderHistory;
