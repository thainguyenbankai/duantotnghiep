import { Head } from '@inertiajs/react';
import ProductCard from '@/Components/ProductCard';
import { ShopOutlined, ExclamationCircleOutlined, TagsOutlined } from '@ant-design/icons';

const CateProducts = ({ data }) => {
    return (
        <>
            <Head title="Danh mục sản phẩm" />
            <div className="container mx-auto p-5 py-8">
                {data.brand ? (
                    <div className="category-section w-full bg-white rounded-lg shadow p-6">
                        <h2 className="text-3xl font-bold text-gray-800 text-center mb-6 flex items-center justify-center">
                            <ShopOutlined className="mr-2 text-lg" />
                            {data.brand.name}
                        </h2>
                        {data.brand.products.length > 0 ? (
                            <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                                {data.brand.products.map((product) => (
                                    <ProductCard key={product.id} product={product} />
                                ))}
                            </div>
                        ) : (
                            <p className="text-gray-600 text-center mt-6 flex items-center justify-center">
                                <ExclamationCircleOutlined className="mr-2" />
                                Không có sản phẩm nào.
                            </p>
                        )}
                    </div>
                ) : (
                    <div className="all-products-section w-full">
                        <h2 className="text-3xl font-bold text-gray-800 text-center mb-6">
                            Danh mục sản phẩm
                        </h2>
                        {data.brands.length > 0 ? (
                            <div className="space-y-8">
                                {data.brands.map((brand) => (
                                    <div key={brand.id} className="brand-section bg-white rounded-lg shadow p-6">
                                        <h3 className="text-2xl font-semibold text-gray-700 mb-4 flex items-center">
                                            <TagsOutlined className="mr-2 text-lg" />
                                            {brand.name}
                                        </h3>
                                        {brand.products.length > 0 ? (
                                            <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                                                {brand.products.map((product) => (
                                                    <ProductCard key={product.id} product={product} />
                                                ))}
                                            </div>
                                        ) : (
                                            <p className="text-gray-600 text-center mt-4 flex items-center justify-center">
                                                <ExclamationCircleOutlined className="mr-2" />
                                                Không có sản phẩm nào cho thương hiệu này.
                                            </p>
                                        )}
                                    </div>
                                ))}
                            </div>
                        ) : (
                            <p className="text-gray-600 text-center mt-6 flex items-center justify-center">
                                <ExclamationCircleOutlined className="mr-2" />
                                Không có thương hiệu nào.
                            </p>
                        )}
                    </div>
                )}
            </div>
        </>
    );
};

export default CateProducts;
