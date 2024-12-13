import React from "react";
import { Carousel, Button, Tooltip } from "antd";

const vouchers = [
    { code: "SHOPEE20", discount: "Giảm 20.000 đ", description: "Mã giảm 20.000 cho khách hàng " },
    { code: "SHOPEE21", discount: "Giảm 30.000 đ", description: "Mã giảm 30.000 " },
    { code: "SHOPEE22", discount: "Giảm 40.000 đ", description: "Mã giảm 40.000" },
    { code: "SHOPEE23", discount: "Giảm 50.000 đ", description: "Mã giảm 50.000 cho sản phẩm" },
];

const VoucherList = () => {
    const copyToClipboard = (code) => {
        navigator.clipboard.writeText(code)
            .then(() => {
                alert(`Mã giảm giá ${code} đã được sao chép!`);
            })
            .catch((err) => {
                console.error('Lỗi khi sao chép mã giảm giá: ', err);
            });
    };

    return (
        <div className="p-6 bg-gray-50">
            <Carousel
                dots={false}
                slidesToShow={4}
                responsive={[
                    { breakpoint: 320, settings: { slidesToShow: 1 } },
                    { breakpoint: 640, settings: { slidesToShow: 2 } },
                    { breakpoint: 1024, settings: { slidesToShow: 3 } },
                    { breakpoint: 1280, settings: { slidesToShow: 4 } },
                ]}
                className="mb-6"
            >
                {vouchers.map((voucher, index) => (
                    <div
                        key={index}
                        className="flex justify-center items-center p-5 bg-white border-2 border-gray-200 rounded-3xl shadow-xl transition-all duration-500 ease-in-out transform hover:scale-110 hover:shadow-2xl hover:bg-blue-50"
                    >
                        <div className="text-center space-y-5">
                            {/* Voucher code */}
                            <p className="text-2xl font-bold text-gray-800">{voucher.code}</p>
                            {/* Voucher description */}
                            <p className="text-sm text-gray-500">{voucher.description}</p>
                            {/* Discount */}
                            <div className="text-xl font-semibold text-blue-600">
                                <span>{voucher.discount}</span>
                            </div>
                            {/* Tooltip and copy button */}
                            <Tooltip title="Click để sao chép mã giảm giá" placement="top">
                                <Button
                                    type="primary"
                                    onClick={(e) => {
                                        e.stopPropagation();
                                        copyToClipboard(voucher.code);
                                    }}
                                    className="w-full mt-4 text-lg font-semibold transition-colors duration-300 bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-md"
                                >
                                    Sao chép
                                </Button>
                            </Tooltip>
                        </div>
                    </div>
                ))}
            </Carousel>
        </div>
    );
};
export default VoucherList;
