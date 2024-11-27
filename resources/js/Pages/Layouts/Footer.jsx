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
        <footer className="bg-gray-800 text-white py-10">
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
                        <p>Số ĐKKD 0135792468 cấp ngày 30/05/2023 tại Sở Kế hoạch Đầu tư TP. Hà Nội</p>
                        <p>Địa chỉ: 266 Đội Cấn, Ba Đình, Hà Nội</p>
                        <p>Email: support@sapo.vn</p>
                        <p>Hotline: 1900 6750</p>
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
                        <li>Dụng cụ điện</li>
                        <li>Thiết bị dùng pin</li>
                        <li>Thiết bị nâng đỡ</li>
                        <li>Thang nhôm</li>
                        <li>Dụng cụ khí nén</li>
                        <li>Máy rửa xe</li>
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
                        <li>Quy trình thanh toán</li>
                        <li>An toàn giao dịch</li>
                        <li>Quản lý thông tin xấu</li>
                        <li>Điều khoản áp dụng</li>
                        <li>Chính sách thanh toán</li>
                        <li>Hệ thống cửa hàng</li>
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
                © Bản quyền thuộc về ND Theme | Cung cấp bởi Sapo
            </div>
        </footer>
    );
};
export default FooterLayout;
