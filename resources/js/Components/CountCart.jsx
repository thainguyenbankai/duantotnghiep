import React, { useEffect, useState } from 'react';
import { usePage, Link } from '@inertiajs/react';


function CartCount() {
    const [cartCount, setCartCount] = useState(0);
    const [userId, setUserId] = useState(null);
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    useEffect(() => {
        const fetchCartCount = async () => {
            try {
                const response = await fetch('/api/count/cart', {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken, 
                    },
                    credentials: 'include', 
                });

                if (!response.ok) {
                    throw new Error('Failed to fetch cart count');
                }

                const data = await response.json();
                setCartCount(data.count);
                setUserId(data.uid);
            } catch (error) {
                console.error('Error fetching cart count:', error);
            }
        };

        fetchCartCount();
    }, [csrfToken]); // Thêm csrfToken vào dependency array

    return (
        <Link href={route('cart')} className="cursor-pointer flex items-center">
            <i className="fas fa-shopping-cart"></i>
            <span className="text-xs text-gray-400 ml-1">
                {cartCount}
            </span>
        </Link>
    );
}

export default CartCount;
