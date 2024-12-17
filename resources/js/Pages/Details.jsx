import React, { useEffect, useState } from 'react';
import { Button, Typography, Row, Col, Card, Carousel, Tag, Space, notification } from 'antd';
import '../../css/Details.css';
import Comment from '@/Components/Comment';

const { Title, Text } = Typography;


const ProductDetail = ({ productData }) => {
    const [product, setProduct] = useState(productData || {});
    const [quantity, setQuantity] = useState(1);
    const [selectedOptionId, setSelectedOptionId] = useState(null);
    const [selectedColorId, setSelectedColorId] = useState(null);
    const [totalPrice, setTotalPrice] = useState(productData?.base_price || 0);
    const [discountedPrice, setDiscountedPrice] = useState(productData?.dis_price || null);

    useEffect(() => {
        if (productData) {
            setProduct(productData);
            setTotalPrice(productData.base_price);
            setDiscountedPrice(productData.dis_price);
        }
    }, [productData]);

    useEffect(() => {
        const selectedVariant = product.variants?.find(
            (variant) =>
                variant.option?.id === selectedOptionId &&
                variant.color?.id === selectedColorId
        );

        const variantPrice = selectedVariant ? selectedVariant.variant_price : product.base_price;

        // Nếu có giá khuyến mãi, kiểm tra xem giá của tùy chọn có nhỏ hơn giá khuyến mãi không
        const variantDiscountPrice = selectedVariant?.dis_price || variantPrice;
        const finalDiscountPrice = product.dis_price && product.dis_price < variantDiscountPrice
            ? product.dis_price
            : variantDiscountPrice;

        setTotalPrice(variantPrice);
        setDiscountedPrice(finalDiscountPrice);
    }, [selectedOptionId, selectedColorId, product]);




    const handleAddToCart = async () => {
        if (!selectedOptionId || !selectedColorId) {
            notification.warning({
                message: 'Chọn đầy đủ thông tin',
                description: 'Vui lòng chọn phiên bản và màu sắc trước khi thêm vào giỏ hàng.',
            });
            return;
        }

        const payload = {
            product_id: product.id,
            option_id: selectedOptionId,
            color_id: selectedColorId,
            quantity,
            price: discountedPrice || totalPrice, // Sử dụng giá khuyến mãi hoặc giá giảm
        };

        try {
            const response = await fetch('/api/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify(payload),
            });

            if (response.ok) {
                const result = await response.json();
                notification.success({
                    message: 'Thành công!',
                    description: result.success,
                });
            } else {
                const error = await response.json();
                notification.error({
                    message: 'Thất bại',
                    description: error.error || 'Không thể thêm vào giỏ hàng.',
                });
            }
        } catch (error) {
            notification.error({
                message: 'Lỗi hệ thống',
                description: 'Không thể kết nối tới máy chủ.',
            });
        }
    };
    const handleCheckout = () => {
        if (!selectedOptionId || !selectedColorId) {
            notification.warning({
                message: 'Chọn đầy đủ thông tin',
                description: 'Vui lòng chọn phiên bản và màu sắc trước khi tiếp tục.',
            });
            return;
        }

        const checkoutProduct = {
            id: product.id,
            name: product.name,
            price: totalPrice,
            quantity,
            option: product.variants?.find(variant => variant.option.id === selectedOptionId)?.option,
            color: product.variants?.find(variant => variant.color.id === selectedColorId)?.color,
        };

        sessionStorage.setItem('checkoutItems', JSON.stringify([checkoutProduct]));
        window.location.href = `${window.location.origin}/checkout`;
    };

    // Tìm các màu sắc tương ứng với thông số (RAM/ROM) đã chọn
    const getColorsForSelectedOption = () => {
        if (!selectedOptionId) return [];
        return product.variants?.filter((variant) => variant.option.id === selectedOptionId)?.map(variant => variant.color) || [];
    };

    return (
        <div className="container mx-auto py-12 px-6">
            <Row gutter={[24, 24]}>
                {/* Hình ảnh sản phẩm */}
                <Col xs={24} md={12}>
                    <Card className="shadow-xl rounded-lg overflow-hidden">
                        <Carousel autoplay effect="fade" className="rounded-lg">
                            {product.images?.map((image, index) => (
                                <div key={index} className="relative">
                                    <img
                                        src={`/${image}`}
                                        alt={product.name}
                                        className="rounded-lg w-full h-96 object-cover transform hover:scale-105 transition-transform duration-500"
                                    />
                                </div>
                            )) || (
                                    <div className="flex items-center justify-center h-96 bg-gray-200">
                                        <span>Không có ảnh</span>
                                    </div>
                                )}
                        </Carousel>
                    </Card>
                </Col>

                {/* Thông tin sản phẩm */}
                <Col xs={24} md={12} className="flex flex-col justify-between">
                    <div className="product-info flex flex-col gap-6">
                        <Title level={2} className="text-gray-800 font-semibold text-2xl">{product.name}</Title>

                        <div className="text-lg font-bold text-red-600 flex items-center gap-4">
                            {/* Hiển thị giá gốc nếu có giá giảm */}
                            {discountedPrice && discountedPrice !== totalPrice && (
                                <Text className="line-through text-gray-500 text-xl">
                                    {new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(totalPrice)}
                                </Text>
                            )}

                            {/* Hiển thị giá giảm giá hoặc giá khuyến mãi */}
                            <Text className={`text-3xl font-semibold ${discountedPrice && discountedPrice !== totalPrice ? 'text-red-600' : ''}`}>
                                {new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(discountedPrice || totalPrice)}
                            </Text>

                        </div>






                        {/* Tùy chọn RAM/ROM */}
                        <div className="flex gap-3">
                            {product.variants
                                ?.map((variant) => variant.option)
                                ?.filter((option, index, self) => self.findIndex(o => o.id === option.id) === index)
                                ?.map((option) => (
                                    <Tag
                                        key={option.id}
                                        color={selectedOptionId === option.id ? 'blue' : 'default'}
                                        className="cursor-pointer hover:bg-blue-600 hover:text-white transition-all duration-300"
                                        onClick={() => setSelectedOptionId(option.id)}
                                    >
                                        {option.ram}GB / {option.rom}GB
                                    </Tag>
                                ))}
                        </div>

                        {/* Màu sắc (chỉ hiển thị khi chọn tùy chọn) */}
                        <div className="flex gap-3">
                            {getColorsForSelectedOption().map((color) => (
                                <Tag
                                    key={color.id}
                                    color={selectedColorId === color.id ? 'red' : 'default'}
                                    className="cursor-pointer hover:bg-red-600 hover:text-white transition-all duration-300"
                                    onClick={() => setSelectedColorId(color.id)}
                                >
                                    {color.name}
                                </Tag>
                            ))}
                        </div>

                        {/* Số lượng */}
                        <div className="flex items-center gap-4">
                            <Text className="font-semibold text-lg">Số lượng:</Text>
                            <input
                                type="number"
                                min={1}
                                value={quantity}
                                onChange={(e) => setQuantity(Number(e.target.value))}
                                className="border rounded-md p-2 w-20 shadow-md"
                            />
                        </div>

                        {/* Nút hành động */}
                        <Space direction="vertical" className="w-full">
                            <Button
                                type="primary"
                                size="large"
                                className="w-full py-4 text-white font-semibold rounded-md shadow-lg hover:bg-blue-600 transition-all duration-300"
                                onClick={handleAddToCart}
                            >
                                Thêm vào giỏ hàng
                            </Button>
                            <Button
                                onClick={handleCheckout}
                                type="default"
                                size="large"
                                className="w-full py-4 text-black font-semibold rounded-md shadow-lg border-2 hover:bg-gray-100 transition-all duration-300"
                            >
                                Mua ngay
                            </Button>
                        </Space>
                    </div>
                </Col>
            </Row>

            {/* Mô tả sản phẩm */}
            <Row className="mt-12">
                <Col span={24}>
                    <Card className="shadow-lg rounded-lg p-6">
                        <Title level={4} className="text-gray-700">Mô tả sản phẩm</Title>
                        <div
                            className="prose lg:prose-xl"
                            dangerouslySetInnerHTML={{
                                __html: product.description || '<p>Thông tin sản phẩm đang được cập nhật.</p>',
                            }}
                        />
                    </Card>
                </Col>
            </Row>
            <Comment product={product} />
        </div>
    );
};

export default ProductDetail;
