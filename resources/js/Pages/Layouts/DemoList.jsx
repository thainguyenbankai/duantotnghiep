import React from "react";
const DemoList = () => {
    return (
        <>
            <div className="container mx-auto features text-center grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 py-2">
                <div className="feature-item flex flex-col items-center">
                    <div className="icon-wrapper bg-pink-100 rounded-full p-6 mb-4">
                        <i className="fas fa-shipping-fast text-4xl"></i>
                    </div>
                    <h3 className="text-xl font-bold">Giao hàng nhanh, miễn phí</h3>
                    <p className="text-sm">Đơn hàng lớn hơn 900K hoặc đăng ký tài khoản được giao hàng miễn phí</p>
                </div>
                <div className="feature-item flex flex-col items-center">
                    <div className="icon-wrapper bg-blue-100 rounded-full p-6 mb-4">
                        <i className="fas fa-undo-alt text-4xl"></i>
                    </div>
                    <h3 className="text-xl font-bold">Trả hàng, Bảo hành</h3>
                    <p className="text-sm">Không thích? Trả lại hoặc đổi hàng của bạn miễn phí trong vòng 30 ngày.</p>
                </div>
                <div className="feature-item flex flex-col items-center">
                    <div className="icon-wrapper bg-yellow-100 rounded-full p-6 mb-4">
                        <i className="fas fa-gift text-4xl"></i>
                    </div>
                    <h3 className="text-xl font-bold">Thành viên</h3>
                    <p className="text-sm">Ưu đãi theo từng cấp bậc hạng thành viên. Sinh nhật quà tặng thành viên</p>
                </div>
                <div className="feature-item flex flex-col items-center">
                    <div className="icon-wrapper bg-purple-100 rounded-full p-6 mb-4">
                        <i className="fas fa-certificate text-4xl"></i>
                    </div>
                    <h3 className="text-xl font-bold">Chính hãng</h3>
                    <p className="text-sm">Sản phẩm chính hãng. Được nhập khẩu 100% từ hãng.</p>
                </div>
            </div>
        </>
    );
};


export default DemoList;
