import React, { useState } from 'react';

const FooterLayout = () => {
    const [isOpen, setIsOpen] = useState({
        contact: false,
        category: false,
        support: false,
        social: false,
    });

    const toggleDropdown = (section) => {
        setIsOpen((prev) => ({
            ...prev,
            [section]: !prev[section],
        }));
    };

    return (
        <footer className="bg-gray-800 text-white py-10 mt-20">
            <div className="container mx-auto grid grid-cols-1 md:grid-cols-4 gap-8">
                {/* Thông Tin Liên Hệ */}
                <div>
                    <h3
                        className="text-lg font-bold mb-4 cursor-pointer md:cursor-default"
                        onClick={() => toggleDropdown('contact')}
                    >
                        THÔNG TIN LIÊN HỆ
                    </h3>
                    <div className={`${isOpen.contact ? 'block' : 'hidden'} md:block`}>
                        <p>Địa chỉ: 123 Magic Street, Hà Nội</p>
                        <p>Email: contact@magicshop.com</p>
                        <p>Hotline: 1900 1234</p>
                        <p>Website: www.magicshop.com</p>
                    </div>
                </div>

                {/* Danh Mục */}
                <div>
                    <h3
                        className="text-lg font-bold mb-4 cursor-pointer md:cursor-default"
                        onClick={() => toggleDropdown('category')}
                    >
                        DANH MỤC
                    </h3>
                    <ul className={`${isOpen.category ? 'block' : 'hidden'} md:block space-y-2`}>
                        <li>Điện thoại</li>
                        <li>Laptop</li>
                    </ul>
                </div>

                {/* Hỗ Trợ Khách Hàng */}
                <div>
                    <h3
                        className="text-lg font-bold mb-4 cursor-pointer md:cursor-default"
                        onClick={() => toggleDropdown('support')}
                    >
                        HỖ TRỢ KHÁCH HÀNG
                    </h3>
                    <ul className={`${isOpen.support ? 'block' : 'hidden'} md:block space-y-2`}>
                        <li>Hướng dẫn sử dụng</li>
                        <li>Câu hỏi thường gặp</li>
                        <li>Chính sách đổi trả</li>
                        <li>Chính sách bảo mật</li>
                        <li>Chăm sóc khách hàng</li>
                    </ul>
                </div>

                {/* Mạng Xã Hội & Phương Thức Thanh Toán */}
                <div>
                    <h3
                        className="text-lg font-bold mb-4 cursor-pointer md:cursor-default"
                        onClick={() => toggleDropdown('social')}
                    >
                        MẠNG XÃ HỘI
                    </h3>
                    <div className={`${isOpen.social ? 'block' : 'hidden'} md:block`}>
                        <div className="flex space-x-4 mb-6">
                            <a href="#" className="bg-pink-500 p-2 rounded-full text-white hover:bg-pink-600 transition">
                                <i className="fab fa-instagram"></i>
                            </a>
                            <a href="#" className="bg-blue-500 p-2 rounded-full text-white hover:bg-blue-600 transition">
                                <i className="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" className="bg-red-500 p-2 rounded-full text-white hover:bg-red-600 transition">
                                <i className="fab fa-youtube"></i>
                            </a>
                            <a href="#" className="bg-blue-400 p-2 rounded-full text-white hover:bg-blue-500 transition">
                                <i className="fab fa-twitter"></i>
                            </a>
                        </div>
                        <h3 className="text-lg font-bold mb-4">PHƯƠNG THỨC THANH TOÁN</h3>
                        <div className="flex space-x-4">
                            <img
                                src="https://bizweb.dktcdn.net/100/517/497/themes/956320/assets/icon_payment_1.png?1728126696498"
                                alt="Tiền Mặt"
                                className="w-10 sm:w-12"
                            />
                            <img
                                src="https://bizweb.dktcdn.net/100/517/497/themes/956320/assets/icon_payment_2.png?1728126696498"
                                alt="Chuyển Khoản"
                                className="w-10 sm:w-12"
                            />
                            <img
                                src="https://bizweb.dktcdn.net/100/517/497/themes/956320/assets/icon_payment_3.png?1728126696498"
                                alt="Visa"
                                className="w-10 sm:w-12"
                            />
                            <img
                                src="https://bizweb.dktcdn.net/100/517/497/themes/956320/assets/icon_payment_4.png?1728126696498"
                                alt="Momo"
                                className="w-10 sm:w-12"
                            />
                        </div>
                    </div>
                </div>
            </div>
            <div className="text-center text-sm mt-8">
                © Bản quyền thuộc về Magic Shop | Cung cấp bởi FPT Polytechnic
            </div>
        </footer>
    );
};

export default FooterLayout;
