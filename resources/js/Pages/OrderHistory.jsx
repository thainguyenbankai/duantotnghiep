import React, { useEffect, useState } from 'react';
import axios from 'axios';

import { List, Avatar, Button } from 'antd';
import { DownOutlined } from '@ant-design/icons';
import { Link } from '@inertiajs/inertia-react';
const OrderHistory = () => {
  const [orders, setOrders] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  const [openDropdown, setOpenDropdown] = useState(null);

  const formatDate = (dateString) => {
    const date = new Date(dateString);
    return date.toISOString().split('T')[0];
  };
  useEffect(() => {
    const fetchOrders = async () => {
      try {
        const response = await axios.get('/api/orders/history');
        setOrders(response.data);
      } catch (err) {
        setError(err.message);
      } finally {
        setLoading(false);
      }
    };
    fetchOrders();
  }, []);

  const toggleDropdown = (orderId) => {
    setOpenDropdown(openDropdown === orderId ? null : orderId);
  };

  const cancelOrder = async (orderId) => {
    try {
      const response = await axios.delete(`/api/orders/${orderId}`);
      if (response.status === 200) {
        setOrders(orders.filter(order => order.id !== orderId));
        message.success('Đơn hàng đã được hủy thành công');
      } else {
        message.error('Không thể hủy đơn hàng');
      }
    } catch (error) {
      message.error('Đã xảy ra lỗi, vui lòng thử lại sau.');
    }
  };

  if (loading) {
    return <div className="text-center mt-10">Loading...</div>;
  }

  if (error) {
    return <div className="text-red-500 text-center mt-10">Error: {error}</div>;
  }

  return (
    <>
      <div className="mt-6 flow-root sm:mt-8 container mx-auto">
        <div className="divide-y divide-gray-200 dark:divide-gray-700">
          {orders.map((order) => (
            <div key={order.id} className="flex flex-wrap items-center gap-y-4 py-6">
              <dl className="w-1/2 sm:w-1/4 lg:w-auto lg:flex-1">
                <dt className="text-base font-medium text-gray-500 dark:text-gray-400">Mã đơn hàng</dt>
                <dd className="mt-1.5 text-base font-semibold text-gray-900 dark:text-white">
                  <a href="#" className="hover:underline">
                    # {order.id}
                  </a>
                </dd>
              </dl>

              <dl className="w-1/2 sm:w-1/4 lg:w-auto lg:flex-1">
                <dt className="text-base font-medium text-gray-500 dark:text-gray-400">Tổng đơn hàng</dt>
                <dd className="mt-1.5 text-base font-semibold text-gray-900 dark:text-white">
                  ${order.total_amount}
                </dd>
              </dl>

              <dl className="w-1/2 sm:w-1/4 lg:w-auto lg:flex-1">
                <dt className="text-base font-medium text-gray-500 dark:text-gray-400">Trạng thái</dt>
                <dd className="me-2 mt-1.5 inline-flex items-center rounded bg-primary-100 px-2.5 py-0.5 text-xs font-medium text-primary-800 dark:bg-primary-900 dark:text-primary-300">
                  {order.name}
                </dd>
              </dl>

              <dl className="w-1/2 sm:w-1/4 lg:w-auto lg:flex-1">
                <dt className="text-base font-medium text-gray-500 dark:text-gray-400">Ngày lên đơn</dt>
                <dd className="mt-1.5 text-base font-semibold text-gray-900 dark:text-white">
                  {formatDate(order.created_at)}
                </dd>
              </dl>

              <div className="w-full grid sm:grid-cols-2 lg:flex lg:w-64 lg:items-center lg:justify-end gap-4">
                <Button
                  type="danger"
                  className="w-full lg:w-auto"
                  onClick={() => cancelOrder(order.id)}
                >
                  Hủy đơn hàng
                </Button>

                <Button
                  type="default"
                  onClick={() => toggleDropdown(order.id)}
                  className="w-full lg:w-auto"
                >
                  Xem chi tiết <DownOutlined />
                </Button>
              </div>
              {openDropdown === order.id && (
                <div className="w-full mt-4 bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4">
                  <List
                    itemLayout="horizontal"
                    dataSource={order.products}
                    renderItem={(product) => (
                      <List.Item
                        actions={[
                          <Link
                            href={route('products.show', { id: product.id })}
                            className="product-button w-full h-full bg-gradient-to-r from-yellow-400 to-red-500 text-white font-semibold py-3 px-20 rounded-lg
                transition-all duration-300 transform hover:scale-105 hover:from-yellow-500 hover:to-red-600
                focus:outline-none focus:ring-2 focus:ring-red-400"
                          >
                            Xem chi tiết
                          </Link>
                        ]}
                      >
                        <List.Item.Meta
                          avatar={<Avatar src={product.image} />}
                          title={product.name}
                          description={`${product.price.toLocaleString()} VNĐ`}
                        />
                      </List.Item>
                    )}
                  />
                </div>
              )}
            </div>
          ))}
        </div>
      </div>
    </>
  );
};
export default OrderHistory;
