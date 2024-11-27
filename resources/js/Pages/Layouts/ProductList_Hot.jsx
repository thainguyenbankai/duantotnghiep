import React from 'react';
import ProductCard from '../../Components/ProductCard';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

const ProductList = ({ products }) => {
    return (
        <>
            <div className="product-list container mx-auto p-6 bg-gradient-to-r from-red-300 to-yellow-300 rounded-lg shadow-lg">
                <div className="product__new mb-10 text-center bg-gradient-to-r from-red-300 to-yellow-300 p-6 rounded-lg shadow-md">
                    <h1 className="text-4xl font-bold text-red-700 mb-2">SẢN PHẨM NHIỀU LƯỢT XEM</h1>
                    <p className="text-lg text-gray-700">Khám phá các sản phẩm nổi bật đang được yêu thích.</p>
                </div>
                <div className="product-list__body grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    {products.length > 0 ? (
                        products.map((product) => (
                            <div
                                key={product.id}
                                className="flex justify-center transition-transform duration-300 ease-in-out transform"
                            >
                                <ProductCard product={product} />
                            </div>
                        ))
                    ) : (
                        <p className="col-span-1 sm:col-span-2 lg:col-span-3 xl:col-span-4 text-gray-500 text-center text-xl">
                            Không có sản phẩm nào để hiển thị.
                        </p>
                    )}
                </div>
            </div>

            {/* Banner Section with smooth scroll transition */}
            <div className="banner mt-6 flex items-center container mx-auto rounded-lg transition-all duration-500 ease-in-out transform hover:scale-105 hover:shadow-2xl blur-effect">
                <img
                    src="/storage/images/xe.webp"
                    alt="Banner"
                    className="flex-none w-1/2 h-auto rounded-lg shadow-lg mb-4 transition-all duration-500 ease-in-out"
                />
                <div className="flex-1 ml-4 text-left">
                    <h2 className="text-4xl font-bold text-red-600 mb-4 transition-all duration-300 ease-in-out hover:text-red-800">
                        Giao hàng 24 / 7
                    </h2>
                    <p className="text-lg text-gray-700 mb-2">
                        Tận hưởng dịch vụ của chúng tôi! Chúng tôi cam kết giao hàng nhanh chóng và an toàn đến tay bạn.
                        Với đội ngũ giao hàng chuyên nghiệp, mọi đơn hàng sẽ được xử lý nhanh nhất có thể.
                    </p>
                    <p className="text-lg text-gray-700 mb-4">
                        Hãy tận dụng các ưu đãi đặc biệt và dịch vụ chăm sóc khách hàng tận tình của chúng tôi.
                        Chúng tôi luôn sẵn sàng phục vụ bạn mọi lúc, mọi nơi!
                    </p>
                    <br />
                    <br />
                    <span className="inline-block bg-red-600 text-white font-semibold py-2 px-4 rounded-lg shadow-lg hover:bg-red-500 transition duration-200 cursor-pointer">
                        Đặt hàng ngay nhé
                    </span>
                </div>
            </div>
        </>
    );
};

export default ProductList;
