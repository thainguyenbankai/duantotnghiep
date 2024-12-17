import React, { useCallback } from 'react';
import PropTypes from 'prop-types';
import { Link } from '@inertiajs/inertia-react';
import { Card, Button, message } from 'antd';
import { HeartOutlined, ShoppingCartOutlined, EyeOutlined, EyeFilled } from '@ant-design/icons';
import '../../css/abouts.css';

const { Meta } = Card;

const handleAddToFavorites = async (productId) => {
    try {
        const response = await fetch('/api/favorites', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ productId })
        });

        const data = await response.json();

        if (response.ok) {
            message.success(data.message);
        } else {
            message.error(data.message);
        }
    } catch (error) {
        console.error('Error adding to favorites', error);
        message.error('Lỗi xảy ra khi thêm vào yêu thích.');
    }
};

const ProductCard = ({ product }) => {
    const images = product.images ? JSON.parse(product.images) : [];
    const imageUrl = images.length > 0 ? `/${images[0]}` : null;
    const productName = product.name || 'Sản phẩm không tên';
    const price = typeof product.price === 'string' ? Number(product.price) : product.price;

    const productDescription = (() => {
        try {
            const parsedDescription = JSON.parse(product.description);
            return Array.isArray(parsedDescription) ? parsedDescription.join(' ') : parsedDescription;
        } catch {
            return product.description || 'Mô tả không có sẵn.';
        }
    })();

    const isOutOfStock = product.quantity === 0; // Kiểm tra sản phẩm hết hàng

    const handleViewProduct = () => {
        // Chỉ cho phép xem chi tiết nếu sản phẩm còn hàng
        if (!isOutOfStock) {
            axios.post(`/api/products/${product.id}/view`)
                .then((response) => {
                    if (response.data.success) {
                        console.log(`Lượt xem cập nhật: ${response.data.view}`);
                    }
                })
                .catch((error) => {
                    console.error('Error updating view count:', error);
                });
        }
    };

    return (
        <Card
            hoverable
            className="product-card shadow-lg rounded-lg overflow-hidden border border-gray-200 h-full"
            cover={
                imageUrl ? (
                    <Link href={route('products.show', { id: product.id })} onClick={handleViewProduct}>
                        <img alt={productName} src={imageUrl} className="product-image m-auto" />
                    </Link>
                ) : (
                    <div className="product-image-placeholder flex items-center justify-center bg-gray-200">
                        <span className="text-gray-400">Không có ảnh</span>
                    </div>
                )
            }
            actions={[
                !isOutOfStock && (
                    <Button
                        type="link"
                        icon={<HeartOutlined />}
                        onClick={() => handleAddToFavorites(product.id)}
                        className="text-red-500 hover:text-red-600 w-full"
                    >
                        Yêu thích
                    </Button>
                ),
                isOutOfStock ? (
                    <Button type="link" disabled className="text-gray-500 w-full">
                        Hết hàng
                    </Button>
                ) : (
                    <Link href={route('products.show', { id: product.id })} onClick={handleViewProduct}>
                        <Button
                            type="link"
                            icon={<EyeOutlined />}
                            className="text-green-500 hover:text-green-600 w-full"
                        >
                            Xem chi tiết
                        </Button>
                    </Link>
                )
            ]}
        >
            <Meta
                description={
                    <>
                        <span className="product-name text-lg font-bold text-gray-900 ">{productName}</span>
                        <p className="text-2xl text-red-500 font-bold">
                            {product.dis_price ? (
                                <>
                                    {new Intl.NumberFormat('vi-VN').format(product.dis_price)} đ
                                    <span className="line-through text-gray-500 ml-2 text-sm">
                                        {new Intl.NumberFormat('vi-VN').format(product.price)} đ
                                    </span>
                                </>
                            ) : (
                                new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(product.price)
                            )}
                        </p>

                        <div className="product-views text-sm text-gray-500 flex items-center">
                            <EyeFilled className="mr-1" />
                            {product.view} lượt xem
                        </div>
                    </>
                }
            />
        </Card>
    );
};

ProductCard.propTypes = {
    product: PropTypes.shape({
        id: PropTypes.number.isRequired,
        name: PropTypes.string,
        description: PropTypes.string,
        price: PropTypes.oneOfType([PropTypes.number, PropTypes.string]),
        image: PropTypes.string,
        badgeText: PropTypes.string,
        installment: PropTypes.bool,
        discount: PropTypes.bool,
        voucher: PropTypes.string,
        rating: PropTypes.number,
        views: PropTypes.number,
        reviews: PropTypes.arrayOf(
            PropTypes.shape({
                user: PropTypes.string,
                comment: PropTypes.string,
                rating: PropTypes.number,
            })
        ),
        quantity: PropTypes.number, // Thêm trường quantity để kiểm tra
    }).isRequired,
};

export default ProductCard;
