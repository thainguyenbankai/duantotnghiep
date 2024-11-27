import React, { useEffect, useState } from 'react';
import { Button, InputNumber, Typography, Row, Col, Card, Image, Tag, Space, notification } from 'antd';

import '../../css/Details.css';
import Comment from '@/Components/Comment';

const { Title, Text } = Typography;

const ProductDetail = ({ productData }) => {
    const [product, setProduct] = useState(productData || {});
    const [quantity, setQuantity] = useState(1);
    const [options, setOptions] = useState([]);
    const [colors, setColors] = useState([]);
    const [selectedOption, setSelectedOption] = useState(null);
    const [selectedColor, setSelectedColor] = useState(null);
    const [totalPrice, setTotalPrice] = useState(productData?.base_price || 0);
    const [mainImage, setMainImage] = useState(productData?.image || '/default-image.jpg');
    const [thumbnails, setThumbnails] = useState(productData?.thumbnails || []);

    useEffect(() => {
        if (productData) {
            setProduct(productData);
            setMainImage(productData.image || '/default-image.jpg');
            setThumbnails(productData.thumbnails || []);
            if (productData.options) {
                const optionsArray = Object.entries(productData.options).map(([key, value]) => ({
                    id: key, ...value
                }));
                setOptions(optionsArray);
            }
            if (productData.colors) {
                const colorsArray = Object.entries(productData.colors).map(([key, value]) => ({
                    id: key, ...value
                }));
                setColors(colorsArray);
            }
        }
    }, [productData]);

    useEffect(() => {
        let newTotalPrice = product.base_price || 0;
        if (selectedOption) {
            newTotalPrice += parseFloat(selectedOption.price || 0);
        }
        if (selectedColor) {
            newTotalPrice += parseFloat(selectedColor.price || 0);
        }
        setTotalPrice(newTotalPrice);
    }, [selectedOption, selectedColor, product.base_price]);

    const handleQuantityChange = (value) => {
        setQuantity(value);
    };

    const handleOptionClick = (optionId) => {
        const option = options.find((opt) => opt.id === optionId);
        setSelectedOption(option);
    };

    const handleThumbnailClick = (image) => {
        setMainImage(image);
    };

    const fetchThumbnailColor = async (colorId) => {
        try {
            const response = await fetch(`/api/colors/${colorId}/thumbnail`);
            if (!response.ok) throw new Error('Failed to fetch color thumbnail');
            const data = await response.json();
            return data.thumbnail;
        } catch (error) {
            console.error('Error fetching color thumbnail:', error);
            return null;
        }
    };

    const handleColorClick = async (colorId) => {
        const color = colors.find((col) => col.id === colorId);
        setSelectedColor(color);
        const fetchedThumbnails = await fetchThumbnailColor(colorId);
        if (fetchedThumbnails && fetchedThumbnails.length > 0) {
            setThumbnails(fetchedThumbnails.map(thumbnail => thumbnail.image_url));
            setMainImage(fetchedThumbnails[0].image_url);
        } else {
            setThumbnails([]);
            setMainImage('/default-image.jpg');
        }
    };

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');


    const fetchAddToCart = async ({ Product_ID, Option_ID, Color_ID, quantity, totalPrice }) => {
        try {
            const response = await fetch('/products', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({
                    Product_ID,
                    Option_ID,
                    Color_ID,
                    quantity,
                    totalPrice,
                }),
            });
            if (!response.ok) throw new Error('Failed to add to cart');
            notification.success({
                message: 'Thêm vào giỏ hàng thành công!',
                description: `${product.name} đã được thêm vào giỏ hàng.`,
                placement: 'topRight',
            });
        } catch (error) {
            notification.error({
                message: 'Thêm vào giỏ hàng thất bại',
                description: 'Đã xảy ra lỗi khi thêm sản phẩm vào giỏ hàng. Vui lòng thử lại.',
                placement: 'topRight',
            });
            console.error('Error adding to cart:', error);
        }
    };

    const handleAddToCart = () => {
        fetchAddToCart({
            Product_ID: product.id,
            Option_ID: selectedOption?.id,
            Color_ID: selectedColor?.id,
            quantity,
            totalPrice,
        });
    };

    return (
        <>
            <div className="container overflow-hidden">
                <div className="mx-20 p-4">
                    <div className="flex items-center gap-5 animate-bounce font-bold text-black">
                        <h2 className='text-3xl'>{product.name}</h2>
                        <div class="text-yellow-500 ">
                            ★★★★★
                        </div>
                    </div>
                    <Row gutter={[16, 16]}>
                        <Col xs={24} md={12}>
                            <Card hoverable className="flex h-full justify-center">
                                <div className="overflow-hidden">
                                    <Image
                                        src={mainImage ? `/storage/${mainImage}` : '/default-image.jpg'}
                                        alt={product.name || 'Default Product'}
                                        className="block mx-auto  img__details object-cover rounded-lg shadow-lg"
                                        preview={false}
                                    />
                                </div>
                            </Card>
                            <Space className="mt-4 gap-2">
                                {thumbnails.map((thumbnail, index) => (
                                    <Card
                                        key={index}
                                        hoverable
                                        cover={<img alt={`thumbnail-${index}`} src={`/storage/${thumbnail}`} className="w-10 h-10" />}
                                        className="thumbnail-card"
                                        onClick={() => handleThumbnailClick(thumbnail)}
                                    />
                                ))}
                            </Space>
                        </Col>
                        <Col xs={24} md={12}>
                            <div className="container flex flex-col">
                                <Text className="text-lg font-bold text-red-600 mb-4">
                                    Giá: {new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(totalPrice * quantity || 0)}
                                </Text>
                                <Text className="text-gray-600 mb-4">{product.description || 'Mô tả sản phẩm'}</Text>
                            </div>

                            <div>
                                <div className="product__options">
                                    {options.map((option) => (
                                        <Tag
                                            key={option.id}
                                            color={selectedOption === option ? 'blue' : 'default'}
                                            className={` p-5 relative py-3 rounded-lg mr-2 cursor-pointer ${selectedOption === option ? 'bg-blue-500 text-white' : 'hover:bg-blue-100'
                                                }`}
                                            onClick={() => handleOptionClick(option.id)}
                                        >
                                            {selectedOption === option && (
                                                <div className="absolute top-1 right-1 w-3 h-3 bg-red-500 rounded-full flex items-center justify-center text-white text-xs">
                                                    ✓
                                                </div>
                                            )}
                                             <h2 className='text-sm text-black font-bold'>
                                             {option.name}
                                             </h2>
                                            <p className='text-red-600'>{Number(option.price)} đ</p>
                                        </Tag>
                                    ))}
                                </div>
                            </div>

                            <div className="mt-5 flex  flex-col gap-2 product__colors mb-4">
                               <h2 className='text-gray-800'>Chọn màu dưới đây: </h2>
                                <div className="flex">
                                    {colors.map((color) => (
                                        <Tag
                                            key={color.id}
                                            color={selectedColor === color ? 'red' : 'default'}
                                            className={`mr-2 cursor-pointer ${selectedColor === color ? 'bg-blue-500 text-white' : 'hover:bg-blue-100'}`}
                                            onClick={() => handleColorClick(color.id)}
                                        >
                                            {color.name}
                                        </Tag>
                                    ))}
                                </div>
                            </div>

                            <div className="mb-4">
                                <Text className="text-gray-700">Số lượng:</Text>
                                <InputNumber
                                    min={1}
                                    value={quantity}
                                    onChange={handleQuantityChange}
                                    className="ml-2 w-16 border border-gray-300 rounded-md p-1"
                                />
                            </div>

                            <Button
                                type="primary"
                                className="mt-4 w-full"
                                size="large"
                                onClick={handleAddToCart}
                            >
                                Thêm vào giỏ hàng
                            </Button>
                        </Col>
                    </Row>
                </div>
                <Comment product={product} />
            </div>
        </>
    );
};

export default ProductDetail;
