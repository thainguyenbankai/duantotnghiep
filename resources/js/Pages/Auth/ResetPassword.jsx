import { useForm, Head } from '@inertiajs/react';
import { Form, Input, Button, Typography, message } from 'antd';
import { MailOutlined, LockOutlined } from '@ant-design/icons';
import GuestLayout from '@/Layouts/GuestLayout';
import axios from 'axios';

const { Title } = Typography;

export default function ResetPassword({ token, email }) {
    const { data, setData, processing, errors, reset } = useForm({
        token: token,
        email: email,
        old_password: '',
        new_password: '',
        password_confirmation: '',
    });

    const submit = async (e) => {
        e.preventDefault();
        try {
            const response = await axios.post(route('new.password'), {
                token: data.token,
                email: data.email,
                old_password: data.old_password,
                new_password: data.new_password,
                password_confirmation: data.password_confirmation,
            });
            // Xử lý phản hồi thành công
            message.success(response.data.message);
            reset('old_password', 'new_password', 'password_confirmation');
        } catch (error) {
            // Xử lý phản hồi lỗi
            if (error.response && error.response.data) {
                message.error(error.response.data.message || 'Đã xảy ra lỗi');
            } else {
                message.error('Đã xảy ra lỗi');
            }
        }
    };

    return (
        <GuestLayout>
            <Head title="Đặt Lại Mật Khẩu" />
            <div className="max-w-md mx-auto mt-10 p-6 bg-white shadow-md rounded-lg">
                <Title level={2} className="text-center">Đặt Lại Mật Khẩu</Title>

                <Form layout="vertical" onSubmitCapture={submit}>
                    <Form.Item
                        label="Email"
                        validateStatus={errors.email && "error"}
                        help={errors.email}
                    >
                        <Input
                            prefix={<MailOutlined />}
                            type="email"
                            name="email"
                            value={data.email}
                            onChange={(e) => setData('email', e.target.value)}
                            required
                        />
                    </Form.Item>

                    <Form.Item
                        label="Mật khẩu cũ"
                        validateStatus={errors.old_password && "error"}
                        help={errors.old_password}
                    >
                        <Input.Password
                            prefix={<LockOutlined />}
                            name="old_password"
                            value={data.old_password}
                            onChange={(e) => setData('old_password', e.target.value)}
                            required
                        />
                    </Form.Item>

                    <Form.Item
                        label="Mật khẩu mới"
                        validateStatus={errors.new_password && "error"}
                        help={errors.new_password}
                    >
                        <Input.Password
                            prefix={<LockOutlined />}
                            name="new_password"
                            value={data.new_password}
                            onChange={(e) => setData('new_password', e.target.value)}
                            required
                        />
                    </Form.Item>

                    <Form.Item
                        label="Xác nhận mật khẩu mới"
                        validateStatus={errors.password_confirmation && "error"}
                        help={errors.password_confirmation}
                    >
                        <Input.Password
                            prefix={<LockOutlined />}
                            name="password_confirmation"
                            value={data.password_confirmation}
                            onChange={(e) => setData('password_confirmation', e.target.value)}
                            required
                        />
                    </Form.Item>

                    <Form.Item>
                        <Button type="primary" htmlType="submit" loading={processing}>
                            Đặt Lại Mật Khẩu
                        </Button>
                    </Form.Item>
                </Form>
            </div>
        </GuestLayout>
    );
}
