import React from 'react';
import { Table, Typography } from 'antd';

const { Text } = Typography;

const columns = [
  {
    title: 'Tên sản phẩm',
    dataIndex: 'name',
    key: 'name',
  },
  {
    title: 'Đơn giá',
    dataIndex: 'price',
    key: 'price',
    render: (price) => `${parseFloat(price).toLocaleString()} VNĐ`,
  },
  {
    title: 'Số lượng',
    dataIndex: 'quantity',
    key: 'quantity',
  },
  {
    title: 'Tùy chọn',
    dataIndex: 'ramRom',
    key: 'ramRom',
  },
  {
    title: 'Màu sắc',
    dataIndex: 'color',
    key: 'color',
  },
  {
    title: 'Thành tiền',
    dataIndex: 'total',
    key: 'total',
    render: (_, record) => `${(parseFloat(record.price) * record.quantity).toLocaleString()} VNĐ`,
  },
];

const MyTable = ({ cart }) => {
  const dataSource = cart.map((item, index) => ({
    key: index,
    name: item.name,
    price: item.price,
    quantity: item.quantity,
    ramRom: item.option || 'Trống',
    color: item.color || 'Trống',
    total: parseFloat(item.price) * item.quantity,
  }));
  return <Table columns={columns} dataSource={dataSource} pagination={false} />;
};
export default MyTable;
