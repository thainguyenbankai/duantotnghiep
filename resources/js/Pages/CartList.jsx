import React, { useState, useEffect, useMemo, useCallback } from 'react';
import { Button, Checkbox, List, InputNumber, Typography, message } from 'antd';

const { Title, Text } = Typography;

const CartList = ({ cartItems }) => {
    const [selectedItems, setSelectedItems] = useState([]);
    const [selectAll, setSelectAll] = useState(false);
    const [totalPrice, setTotalPrice] = useState(0);
    const [allProducts, setAllProducts] = useState(cartItems);
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    const calculateTotalPrice = useMemo(() => {
        return allProducts.reduce((acc, item, index) => {
            if (selectedItems[index] && item.quantity > 0) {
                return acc + item.price * item.quantity;
            }
            return acc;
        }, 0);
    }, [selectedItems, allProducts]);

    useEffect(() => {
        setTotalPrice(calculateTotalPrice);
    }, [calculateTotalPrice]);

    const showMessage = (msg, type = 'success') => {
        message[type](msg);
    };

    const handleSelectAll = () => {
        const newSelectedItems = new Array(allProducts.length).fill(!selectAll);
        setSelectedItems(newSelectedItems);
        setSelectAll(!selectAll);
    };

    const handleItemSelect = (index) => {
        const newSelectedItems = [...selectedItems];
        newSelectedItems[index] = !newSelectedItems[index];
        setSelectedItems(newSelectedItems);
    };

    const handleRemoveSelected = async () => {
        const idsToRemove = allProducts.filter((_, index) => selectedItems[index]).map(item => item.id);
        if (idsToRemove.length > 0) {
            const updatedProducts = allProducts.filter(item => !idsToRemove.includes(item.id));
            setAllProducts(updatedProducts);
            setSelectedItems(new Array(updatedProducts.length).fill(false));
            setSelectAll(false);
            showMessage('Xóa sản phẩm thành công.');
            try {
                const response = await fetch(`/api/cart/remove`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-Token': csrfToken,
                    },
                    body: JSON.stringify({ ids: idsToRemove }),
                });
                if (!response.ok) {
                    showMessage('Xóa sản phẩm không thành công.', 'error');
                }
            } catch (error) {
                console.error('Error removing products:', error);
                showMessage('Đã xảy ra lỗi khi xóa sản phẩm.', 'error');
            }
        } else {
            showMessage('Vui lòng chọn sản phẩm để xóa.', 'warning');
        }
    };

    const updateQuantity = useCallback(
        async (itemId, newQuantity) => {
            if (newQuantity < 1) return;

            const updatedProducts = allProducts.map(item =>
                item.id === itemId ? { ...item, quantity: newQuantity } : item
            );

            try {
                const response = await fetch(`/api/cart/quantity`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-Token': csrfToken,
                    },
                    body: JSON.stringify({ id: itemId, quantity: newQuantity }),
                });

                if (response.ok) {
                    setAllProducts(updatedProducts); // Cập nhật nếu server phản hồi thành công
                } else {
                    throw new Error('Cập nhật thất bại');
                }
            } catch (error) {
                console.error('Error updating quantity:', error);
                showMessage('Đã xảy ra lỗi khi cập nhật số lượng.', 'error');
            }
        },
        [csrfToken, allProducts]
    );

    const handleCheckout = () => {
        const selectedItemsToCheckout = allProducts.filter((_, index) => selectedItems[index]).map(item => ({
            id: item.product.id,
            name: item.product.name,
            price: item.price,
            quantity: item.quantity,
            option: item.option_name,
            color: item.color_name,
        }));
        if (selectedItemsToCheckout.length > 0) {
            sessionStorage.setItem('checkoutItems', JSON.stringify(selectedItemsToCheckout));
            window.location.href = `${window.location.origin}/checkout`;
        } else {
            showMessage('Vui lòng chọn sản phẩm để thanh toán', 'warning');
        }
    };

    return (
        <div className="container mx-auto px-6 py-10 bg-white rounded-lg shadow-xl mt-10 max-w-7xl">
            <Title level={2} className="text-center mb-8 text-gray-800 font-semibold">
                <i className="fas fa-shopping-cart"></i> Giỏ hàng của bạn
            </Title>
            <div className="flex justify-between items-center mb-6">
                <Button
                    onClick={handleRemoveSelected}
                    type="primary"
                    danger
                    style={{ backgroundColor: '#ff4d4f', borderColor: '#ff4d4f' }}
                    disabled={selectedItems.every(item => !item)}
                    icon={<i className="fas fa-trash-alt"></i>}
                    className="transition-colors duration-200 hover:bg-red-600"
                >
                    Xóa đã chọn
                </Button>
                <Button
                    onClick={handleSelectAll}
                    type="primary"
                    style={{ backgroundColor: '#1890ff', borderColor: '#1890ff' }}
                    icon={selectAll ? <i className="fas fa-times"></i> : <i className="fas fa-check"></i>}
                    className="transition-colors duration-200 hover:bg-blue-700"
                >
                    {selectAll ? 'Bỏ chọn tất cả' : 'Chọn tất cả'}
                </Button>
            </div>

            {allProducts.length > 0 ? (
                <List
                    itemLayout="vertical"
                    dataSource={allProducts}
                    renderItem={(item, index) => (
                        <List.Item
                            key={item.id}
                            className="bg-gray-50 p-4 rounded-xl mb-4 shadow-md hover:shadow-lg transition-all duration-300"
                        >
                            <Checkbox
                                checked={selectedItems[index]}
                                onChange={() => handleItemSelect(index)}
                                className="mr-4"
                            />
                            <List.Item.Meta
                                avatar={
                                    Array.isArray(item.product?.images) && item.product.images.length > 0 ? (
                                        <img
                                            src={`/${item.product.images[0]}`}
                                            alt={item.product.name}
                                            className="rounded-lg w-32 h-32 object-cover"
                                        />
                                    ) : (
                                        <div className="flex items-center justify-center h-32 bg-gray-300 rounded-md">
                                            <span className="text-gray-600">Không có ảnh</span>
                                        </div>
                                    )
                                }
                                title={<Text strong>{item.product?.name}</Text>}
                                description={
                                    <div className="flex flex-col mt-2">
                                        <div className="flex items-center mb-2">
                                            <Text strong>Số lượng:</Text>
                                            <InputNumber
                                                min={1}
                                                value={item.quantity}
                                                onChange={(value) => updateQuantity(item.id, value)}
                                                className="ml-2"
                                            />
                                            <Text className="text-red-500 ml-4">
                                                {new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(
                                                    item.price * item.quantity
                                                )}
                                            </Text>
                                        </div>
                                        <div className="flex items-center mb-2">
                                            <Text strong>Tùy chọn:</Text>
                                            <Text className="ml-2">{item.option_name}</Text>
                                        </div>
                                        <div className="flex items-center mb-2">
                                            <Text strong>Màu sắc:</Text>
                                            <Text className="ml-2">{item.color_name}</Text>
                                        </div>
                                    </div>
                                }
                            />
                        </List.Item>
                    )}
                />
            ) : (
                <Text type="secondary" className="text-center text-gray-500">Giỏ hàng của bạn hiện tại trống</Text>
            )}

            <div className="mt-10 flex justify-between items-center">
                <Title level={3} className="text-gray-800">
                    <i className="fas fa-money-bill-wave"></i> Tổng tiền: {new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(totalPrice)}
                </Title>
                <Button
                    onClick={handleCheckout}
                    type="primary"
                    size="large"
                    style={{ backgroundColor: '#4CAF50', borderColor: '#4CAF50' }}
                    icon={<i className="fas fa-credit-card"></i>}
                    className="transition-colors duration-200 hover:bg-green-700"
                >
                    Thanh toán
                </Button>
            </div>
        </div>
    );
};

export default CartList;
