import React, { useCallback } from 'react';
import PropTypes from 'prop-types';
import { Link } from '@inertiajs/inertia-react';
import { Card, Button, Rate, Tooltip } from 'antd';
import { HeartOutlined, ShoppingCartOutlined, EyeOutlined, EyeFilled } from '@ant-design/icons';

const { Meta } = Card;

const getRandomInt = (min, max) => Math.floor(Math.random() * (max - min + 1)) + min;
const getRandomRating = () => getRandomInt(1, 5);
const getRandomPrice = () => getRandomInt(100000, 1000000);
const getRandomViews = () => getRandomInt(100, 10000);
const getRandomDescription = () => {
    const descriptions = [
        'Sản phẩm tuyệt vời với chất lượng vượt trội.',
        'Thiết kế hiện đại và sang trọng.',
        'Giá cả hợp lý và phải chăng.',
        'Được người tiêu dùng đánh giá cao.',
        'Sản phẩm đáng tin cậy và bền bỉ.'
    ];
    return descriptions[getRandomInt(0, descriptions.length - 1)];
};

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

        if (response.ok) {
            console.log(`Added product ${productId} to favorites`);
        } else {
            console.error('Failed to add to favorites');
        }
    } catch (error) {
        console.error('Error adding to favorites', error);
    }
};

const getRandomReviews = (numReviews = 5) => {
    const names = ['John Doe', 'Jane Smith', 'Alice Johnson', 'Bob Brown', 'Charlie Davis'];
    const comments = [
        'Sản phẩm tuyệt vời!',
        'Chất lượng tốt, sẽ mua lại.',
        'Không hài lòng lắm.',
        'Giá trị tốt cho tiền.',
        'Sản phẩm đạt yêu cầu.'
    ];
    const reviews = [];
    for (let i = 0; i < numReviews; i++) {
        reviews.push({
            user: names[getRandomInt(0, names.length - 1)],
            comment: comments[getRandomInt(0, comments.length - 1)],
            rating: getRandomRating()
        });
    }
    return reviews;
};

const ProductCard = ({ product }) => {
    const imageUrl = product.image ? `storage/${product.image}` : null;
    const productName = product.name || 'Sản phẩm không tên';
    const productDescription = product.description || getRandomDescription();
    const productPrice = product.price !== undefined ? product.price : getRandomPrice();
    const productBadgeText = product.badgeText || 'Không có thông tin';
    const productInstallment = 0;
    const productDiscount = getRandomInt(1, 5) * 10;
    const productVoucher = product.voucher || 'Không có voucher khuyến mãi';
    const productRating = product.rating || getRandomRating();
    const productViews = product.views || getRandomViews();
    const productReviews = product.reviews || getRandomReviews();
    const fiveStarReviews = productReviews.filter(review => review.rating === 5);
    const totalFiveStarReviews = fiveStarReviews.length;

    return (
        <Card
            hoverable
            className="product-card shadow-lg rounded-lg overflow-hidden border border-gray-200 transition-transform duration-300 ease-in-out transform hover:scale-105 hover:bg-gray-50"
            cover={imageUrl ? <img alt={productName} src={imageUrl} className="product-image m-auto" /> :
                <div className="product-image-placeholder flex items-center justify-center bg-gray-200 h-48">
                    <span className="text-gray-400">Không có ảnh</span>
                </div>}
            actions={[
                <Button type="link" icon={<HeartOutlined />} onClick={() => handleAddToFavorites(product.id)} className="text-red-500 hover:text-red-600">
                    Yêu thích
                </Button>,

                <Link href={route('products.show', { id: product.id })}>
                    <Button type="link" icon={<EyeOutlined />} className="text-green-500 hover:text-green-600">
                        Xem chi tiết
                    </Button>
                </Link>,
            ]}
        >
            <Meta
                title={
                    <div className="flex justify-between items-center">
                        <span className="bg-blue-600 text-white text-xs px-2 py-1 rounded ml-2">
                            Trả góp 0%
                        </span>
                        {productDiscount && (
                            <span className="bg-green-600 text-white text-xs px-2 py-1 rounded ml-2">
                                Giảm giá {productDiscount}%
                            </span>
                        )}
                    </div>
                }
                description={
                    <>
                        <span className="product-name text-lg font-bold text-gray-900 truncate">{productName}</span>
                        <div className="product-description text-sm text-gray-500 mb-2">
                            {productDescription && productDescription.length > 80
                                ? `${productDescription.substring(0, 60)}...`
                                : productDescription}
                        </div>
                        <div className="product-price text-xl font-bold text-red-500 mb-2">
                            {new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(productPrice)}
                        </div>
                        <div className="product-rating text-sm text-yellow-500 mb-2">
                            <Rate disabled defaultValue={productRating} />
                        </div>
                        <div className="product-views text-sm text-gray-500 mb-2 flex items-center">
                            <EyeFilled className="mr-1" />
                            {productViews} lượt xem
                        </div>
                        <div className="product-voucher text-sm text-blue-500 mb-2">
                            {productVoucher}
                        </div>
                        <div className="product-reviews mt-4">
                            <div className="flex items-center mb-2 text-yellow-500">
                                <Rate disabled defaultValue={5} className="text-yellow-500 text-sm" />
                                <span className="ml-2 text-gray-700">({totalFiveStarReviews} đánh giá 5 sao)</span>
                            </div>
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
        price: PropTypes.number,
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
    }).isRequired,
};

export default ProductCard;
