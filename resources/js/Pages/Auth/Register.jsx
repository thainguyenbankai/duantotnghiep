import { useForm, Head, Link } from '@inertiajs/react';
import { Form, Input, Button, Typography, Alert, message } from 'antd';
import { UserOutlined, MailOutlined, LockOutlined } from '@ant-design/icons';
import GuestLayout from '@/Layouts/GuestLayout';

const { Title } = Typography;

export default function Register() {
    const { data, setData, post, processing, errors, reset } = useForm({
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
    });
   
    const submit = (e) => {
        e.preventDefault();

        post(route('register'), {
            onSuccess: () => {
                message.success('Đăng ký thành công. Vui lòng kiểm tra email của bạn.');
                reset('password', 'password_confirmation');
            },
            onError: (formErrors) => {
                if (formErrors.error) {
                    message.error(formErrors.error);
                } else {
                    message.error('Đăng ký không thành công. Vui lòng kiểm tra lại.');
                }
            },
        });
    };

    return (
        <GuestLayout>
            <Head title="Register" />
            <div className="max-w-md mx-auto mt-10 p-6 bg-white shadow-md rounded-lg">
                <Title level={2} className="text-center">Đăng Ký</Title>

                {errors.success && (
                    <Alert message={errors.success} type="success" showIcon className="mb-4" />
                )}

                {errors.error && (
                    <Alert message={errors.error} type="error" showIcon className="mb-4" />
                )}

                <Form layout="vertical" onSubmitCapture={submit}>
                    <Form.Item
                        label="Họ và tên"
                        validateStatus={errors.name && "error"}
                        help={errors.name}
                    >
                        <Input
                            prefix={<UserOutlined />}
                            name="name"
                            value={data.name}
                            onChange={(e) => setData('name', e.target.value)}
                            required
                        />
                    </Form.Item>

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
                        label="Mật khẩu"
                        validateStatus={errors.password && "error"}
                        help={errors.password}
                    >
                        <Input.Password
                            prefix={<LockOutlined />}
                            name="password"
                            value={data.password}
                            onChange={(e) => setData('password', e.target.value)}
                            required
                        />
                    </Form.Item>

                    <Form.Item
                        label="Nhập lại mật khẩu"
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
                        <div className="flex items-center justify-between">
                            <Link href={route('login')} className="text-sm text-gray-600 underline hover:text-gray-900">
                                Bạn có tài khoản rồi?
                            </Link>

                            <Button type="primary" htmlType="submit" loading={processing}>
                                Đăng ký
                            </Button>
                        </div>
                    </Form.Item>
                </Form>
            </div>
        </GuestLayout>
    );
}
