import React from 'react';
import ProductCard from '@/Components/ProductCard';

import '../../css/product.css';
axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken;

const SearchResults = ({ results, query, count }) => {
    return (
        <>

            <div className="container mx-auto p-4">
                <h1 className="text-2xl font-bold">Kết quả tìm kiếm cho: "{query}"</h1>
                <p className="text-gray-600">Số lượng sản phẩm tìm thấy: {count}</p>

                {results.length > 0 ? (
                    <div className="w-full p-6 bg-white shadow-md rounded-lg border border-gray-200">

                        <ul className="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                            {results.map((result) => (
                                <ProductCard product={result} />
                            ))}
                        </ul>
                    </div>
                ) : (
                    <p className="mt-4 text-gray-500">Không tìm thấy sản phẩm nào.</p>
                )}
            </div>
        </>
    );
};

export default SearchResults;
