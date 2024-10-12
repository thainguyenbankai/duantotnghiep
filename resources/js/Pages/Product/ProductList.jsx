// src/Pages/Product/ProductList.jsx
import React from 'react';
import ProductCard from '../../Components/ProductCard';

const ProductList = ({ products }) => {
    return (
        <div className="container mx-auto p-4">
            <h1 className="text-2xl font-bold mb-6">Danh sách sản phẩm</h1>
            <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                {products.map(product => (
                    <ProductCard key={product.id} product={product} />
                ))}
            </div>
        </div>
    );
};

export default ProductList;
