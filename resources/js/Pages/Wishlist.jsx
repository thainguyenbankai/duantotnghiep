import React from 'react';
import { Link } from '@inertiajs/react';
import { Table, Layout, Typography, Space, Button } from 'antd';
import { EyeOutlined, HeartOutlined } from '@ant-design/icons';

const { Header, Content } = Layout;
const { Title } = Typography;



function LikedProducts({ likedProducts }) {
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
                    <Button type="danger" icon={<HeartOutlined />} onClick={() => handleUnLike(record.id)}>
                        Bỏ thích
                    </Button>
                </Space>
            ),
        },
    ];

    const handleUnLike = (productId) => {
        console.log(`Bỏ thích sản phẩm: ${productId}`);
    };

    return (
        <Layout className="layout">
            <Header>
                <Title level={2} className="text-white text-center">
                    Danh Sách Sản Phẩm Yêu Thích
                </Title>
            </Header>
            <Content className="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <Table
                    dataSource={likedProducts}
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
