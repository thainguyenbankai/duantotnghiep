import React, { useState } from 'react';
import { Select, Row, Col } from 'antd';
import ProductCard from './ProductCard';
const { Option } = Select;
const CateProduct = ({ categories }) => {
    const [selectedBrand, setSelectedBrand] = useState('all');
    const filteredCategories = categories.map(category => {
        const filteredProducts = category.products.filter(product =>
            selectedBrand === 'all' || product.brand === selectedBrand
        );
        return {
            ...category,
            products: filteredProducts,
        };
    });

    const handleBrandChange = (value) => {
        setSelectedBrand(value);
    };
    const brands = Array.from(new Set(categories.flatMap(category => category.products.map(product => product.brand))));
    return (
        <div className="container mx-auto p-4">
            <div className="mb-4">
                <label htmlFor="brand-filter" className="mr-2 text-gray-700">Lọc theo thương hiệu:</label>
                <Select
                    id="brand-filter"
                    value={selectedBrand}
                    onChange={handleBrandChange}
                    className="w-full sm:w-auto"
                    style={{ width: '200px' }}
                >
                    <Option value="all">Tất cả</Option>
                    {brands.map((brand) => (
                        <Option key={brand} value={brand}>
                            {brand}
                        </Option>
                    ))}
                </Select>
            </div>
            {filteredCategories.map((category) => (
                <div key={category.id} className="mb-12">
                    <h2 className="text-3xl font-bold mb-4 text-gray-800 border-b-2 border-gray-300 pb-2">
                        {category.name}
                    </h2>

                    <Row gutter={[16, 16]}>
                        {category.products.map((product) => (
                            <Col key={product.id} xs={24} sm={12} lg={8}>
                                <ProductCard product={product} />
                            </Col>
                        ))}
                    </Row>
                </div>
            ))}
        </div>
    );
};

export default CateProduct;
