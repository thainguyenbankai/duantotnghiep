import React, { useState, useEffect } from "react";
import { Link } from '@inertiajs/inertia-react';

const GetListCategory = () => {
    const [categories, setCategories] = useState([]);

    const fetchCategory = async () => {
        try {
            const response = await fetch('/list/category'); 
            if (response.ok) { 
                const data = await response.json();
                setCategories(data.categories); 
            } else {
                console.error('Error fetching categories:', response.statusText);
            }
        } catch (e) {
            console.error('Fetch error:', e);
        }
    };

    useEffect(() => {
        fetchCategory(); 
    }, []);

    return (
        <div className="cate__gory bg-white text-gray-800">
            {categories.length === 0 ? ( 
                <p>Không có danh mục nào.</p>
            ) : (
                <div>
                    <Link href="/categories/" className="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        Tất cả sản phẩm
                    </Link>
                    {categories.map((category) => {
                        const categoryUrl = `/categories/${category.id}`;
                        console.log(categoryUrl); 
                        return (
                            <Link 
                                key={category.id} 
                                href={categoryUrl} 
                                className="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                            >
                                {category.name}
                            </Link>
                        );
                    })}
                </div>
            )}
        </div>
    );
};

export default GetListCategory;
