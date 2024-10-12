// src/Components/ProductCard.jsx
import React from 'react';

const ProductCard = ({ product }) => {
    const imageUrl = product.image ? `/storage/${product.image}` : '/default-image.jpg';
    return (
        <div className="product-card bg-white shadow-lg rounded-lg overflow-hidden p-4">
            {product.image && (
                <img
                    src={imageUrl}
                    alt={product.name}
                    className="product-image w-full h-48 object-cover"
                />
            )}
            <div className="p-4">
                <h2 className="product-name text-xl font-semibold mb-2">{product.name}</h2>
                <p className="product-description text-gray-600 mb-4">{product.description}</p>
                <p className="product-price text-lg font-bold text-gray-800">
                    Price: {new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(product.price)}
                </p>
                <p className="product-quantity text-gray-500">Quantity: {product.quantity}</p>
            </div>
        </div>
    );
};

export default ProductCard;
