import React, { useEffect, useState } from 'react';
import axios from 'axios';

const CartCount = () => {
    const [cartCount, setCartCount] = useState(0);

    const fetchCartCount = async () => {
        try {
            const response = await axios.get('/api/count/cart');
            if (response.status === 200) {
                setCartCount(response.data.count);
            }
        } catch (error) {
            console.error('Lỗi khi lấy số lượng giỏ hàng:', error);
            setCartCount(0);
        }
    };

    useEffect(() => {
        fetchCartCount(); // Gọi hàm khi component được mount
        const interval = setInterval(fetchCartCount, 5000); // Cập nhật mỗi 5 giây

        return () => clearInterval(interval); // Hủy interval khi unmount
    }, []);

    return (
        <div className="navbar__item cursor-pointer">
            <i className="fas fa-shopping-cart"></i>
            <span className="ml-2">{cartCount}</span>
        </div>
    );
};

export default CartCount;