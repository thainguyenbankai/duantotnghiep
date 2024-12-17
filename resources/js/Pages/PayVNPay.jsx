import React, { useState } from 'react';
import { Layout, Row, Typography, Button, Space, message } from 'antd';
import axios from 'axios';

const { Title, Text } = Typography;
const { Content } = Layout;
axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken;

const PayVNPay = ({ orderId, totalAmount }) => {
    const VNPayConfig = {
        apiUrl: process.env.REACT_APP_VNPAY_URL,
        vnp_TmnCode: process.env.REACT_APP_VNPAY_TMN_CODE,
        vnp_HashSecret: process.env.REACT_APP_VNPAY_HASH_SECRET,
        vnp_ReturnUrl: process.env.REACT_APP_VNPAY_RETURN_URL,
    };

    const [paymentUrl, setPaymentUrl] = useState('');
    const [isPaymentInitiated, setIsPaymentInitiated] = useState(false);

    // Hàm khởi tạo thanh toán
    const initiatePayment = async () => {
        try {
            const vnp_Amount = totalAmount * 100; // VNPay yêu cầu số tiền tính theo đồng (100 VNĐ = 1 VND)
            const vnp_TxnRef = `ORDER-${orderId}-${Date.now()}`; // Mã giao dịch duy nhất
            const vnp_OrderInfo = `Thanh toán đơn hàng #${orderId}`;

            // Tạo request URL cho VNPay
            const params = {
                vnp_TmnCode: VNPayConfig.vnp_TmnCode,
                vnp_Amount: vnp_Amount,
                vnp_Command: "pay",
                vnp_CreateDate: new Date().toISOString().replace(/[-:.TZ]/g, ""), // Định dạng ngày tháng YmdHis
                vnp_CurrCode: "VND",
                vnp_IpAddr: window.location.hostname, // Sử dụng địa chỉ IP của máy khách
                vnp_Locale: "vn",
                vnp_OrderInfo: vnp_OrderInfo,
                vnp_ReturnUrl: VNPayConfig.vnp_ReturnUrl,
                vnp_TxnRef: vnp_TxnRef,
                vnp_Version: "2.1.0",
            };

            // Gửi yêu cầu POST để tạo URL thanh toán
            const { data } = await axios.post('/api/vnpay/url', params);

            if (data?.paymentUrl) {
                setPaymentUrl(data.paymentUrl);
                setIsPaymentInitiated(true);
                message.success('URL thanh toán đã được khởi tạo thành công!');
            } else {
                message.error('Không thể nhận được URL thanh toán. Vui lòng thử lại.');
            }
        } catch (error) {
            console.error(error);
            message.error(`Lỗi khi khởi tạo thanh toán VNPay: ${error.response ? error.response.data.message : error.message}`);
        }
    };

    return (
        <Layout>
            <Content className="p-6 max-w-5xl mx-auto bg-white shadow rounded-md">
                <Title level={2} className="text-center">Thanh Toán VNPay</Title>
                <Row justify="center" className="text-center">
                    {!isPaymentInitiated ? (
                        <Button
                            type="primary"
                            onClick={initiatePayment}
                            size="large"
                        >
                            Thanh Toán Ngay
                        </Button>
                    ) : (
                        <Space direction="vertical" className="mt-4">
                            <Text>Click vào nút bên dưới để hoàn tất thanh toán:</Text>
                            <Button
                                type="primary"
                                size="large"
                                href={paymentUrl}
                                target="_blank"
                            >
                                Đến VNPay
                            </Button>
                            <Button
                                type="default"
                                onClick={() => setIsPaymentInitiated(false)}
                            >
                                Hủy Bỏ
                            </Button>
                        </Space>
                    )}
                </Row>
            </Content>
        </Layout>
    );
};

export default PayVNPay;
