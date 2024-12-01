import React from 'react';
import { Link } from '@inertiajs/react';
import { Table, Layout, Typography, Space, Button, message } from 'antd';
import { EyeOutlined, HeartOutlined } from '@ant-design/icons';

const { Header, Content } = Layout;
const { Title } = Typography;

function LikedProducts({ wishlists }) {
    const columns = [
        {
            title: 'Tên Sản Phẩm',
            dataIndex: 'name',
            key: 'name',
            render: (text, record) => (
                <Link href={route('products.show', { id: record.id })}>
                    <Button type="link" icon={<EyeOutlined />} className="text-green-500 hover:text-green-600">
                        {text}
                    </Button>
                </Link>
            ),
        },
        {
            title: 'Giá',
            dataIndex: 'price',
            key: 'price',
            render: (text) => `${text.toLocaleString()} ₫`,
        },
        {
            title: 'Hành động',
            key: 'action',
            render: (text, record) => (
                <Space size="middle">
                    <Link href={route('products.show', { id: record.id })}>
                        <Button type="primary" icon={<EyeOutlined />}>
                            Xem chi tiết
                        </Button>
                    </Link>
                    <Button type="danger" icon={<HeartOutlined />} onClick={() => handleUnLike(record.product.id)}>
                        Bỏ thích
                    </Button>
                </Space>
            ),
        },
    ];

    const handleUnLike = async (productId) => {
        try {
            const response = await fetch(`/api/favorites/${productId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            const data = await response.json();

            if (response.ok) {
                message.success(data.message);
            } else {
                message.error(data.message);
            }
        } catch (error) {
            console.error('Error removing from favorites', error);
            message.error('Lỗi xảy ra khi bỏ thích.');
        }
    };

    const dataSource = wishlists.map(wishlist => ({
        id: wishlist.product.id,
        name: wishlist.product.name,
        price: wishlist.product.price,
    }));

    return (
        <Layout className="layout">
            <Header>
                <Title level={2} className="text-white text-center">
                    Danh Sách Sản Phẩm Yêu Thích
                </Title>
            </Header>
            <Content className="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <Table
                    dataSource={dataSource}
                    columns={columns}
                    rowKey="id"
                    pagination={false}
                    bordered
                    className="bg-white shadow-md rounded-lg"
                />
            </Content>
        </Layout>
    );
}

export default LikedProducts;
