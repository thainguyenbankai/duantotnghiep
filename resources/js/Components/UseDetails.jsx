import { useState, useEffect } from 'react';
import axios from 'axios';

const useProductDetail = (product) => {
  
    const [quantity, setQuantity] = useState(1);
    const [message, setMessage] = useState({ text: '', type: '' });
    const [options, setOptions] = useState(product.options || []);
    const [colors, setColors] = useState(product.colors || []); // Assuming 'colors' is an array in the product object
    const [image, setImageUrl] = useState(product.image ? `/${product.image}` : '/default-image.jpg');
    const [selectedVariantId, setSelectedVariantId] = useState(options.length > 0 ? options[0].id : null);
    const [selectedColor, setSelectedColor] = useState(null);
    const [price, setPrice] = useState(product.base_price);

    useEffect(() => {
        console.log("Product data:", product);
        // Set options and default variant image
        if (product.options && product.options.length > 0) {
            setOptions(product.options);
            setSelectedVariantId(product.options[0].id);
            const optionImage = product.options[0].image ? `/${product.options[0].image}` : '/default-image.jpg';
            setImageUrl(optionImage);
        } else {
            setImageUrl(product.image ? `/${product.image}` : '/default-image.jpg');
        }
        setPrice(product.base_price); // Ensure the price is updated
    }, [product]);

    const handleVariantClick = (variantId, color = null) => {
        const selectedOption = options.find(option => option.id === variantId);
        if (selectedOption) {
            setSelectedVariantId(variantId);
            setPrice(selectedOption.price);
            const optionImage = selectedOption.image ? `/${selectedOption.image}` : '/default-image.jpg';
            setImageUrl(optionImage);
            setSelectedColor(color || null); // Set color if passed
        }
    };

    const handleColorChange = (color) => {
        setSelectedColor(color);
    };

    const handleAddToCart = async () => {
        // Validate that a variant and color are selected
        if (product.options && product.options.length > 0) {
            if (!selectedVariantId || !selectedColor) {
                setMessage({ text: 'Vui lòng chọn tùy chọn và màu sắc trước khi thêm vào giỏ hàng.', type: 'error' });
                return;
            }
        }

        try {
            const selectedOption = options.find(option => option.id === selectedVariantId) || {};
            const optionsString = `${selectedOption.ram || ''}/${selectedOption.rom || ''}`;

            await axios.post('/api/cart/add', {
                id: product.id,
                name: product.name,
                price: price,
                quantity,
                options: [optionsString, selectedColor],
                image,
            });

            const cart = JSON.parse(localStorage.getItem("cart")) || [];
            const newCartItem = {
                id: product.id,
                name: product.name,
                price: price,
                quantity,
                options: [selectedOption.ram, selectedOption.rom, selectedColor],
                image,
            };
            const existingItemIndex = cart.findIndex(item =>
                item.id === product.id &&
                JSON.stringify(item.options) === JSON.stringify(newCartItem.options)
            );

            if (existingItemIndex >= 0) {
                cart[existingItemIndex].quantity += quantity;
            } else {
                cart.push(newCartItem);
            }
            localStorage.setItem("cart", JSON.stringify(cart));
            showMessage('Đã thêm vào giỏ hàng!', 'success');
        } catch (error) {
            console.error('Lỗi khi thêm vào giỏ hàng:', error);
            showMessage('Thêm vào giỏ hàng thất bại.', 'error');
        }
    };

    const showMessage = (msg, type) => {
        setMessage({ text: msg, type });
        setTimeout(() => setMessage({ text: '', type: '' }), 2000);
    };

    return {
        quantity,
        setQuantity,
        message,
        options,
        colors, 
        image,
        selectedVariantId,
        price,
        selectedColor,
        handleVariantClick,
        handleColorChange,
        handleAddToCart,
    };
};

export default useProductDetail;
