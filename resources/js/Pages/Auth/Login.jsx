import { useEffect } from 'react';
import { useForm, Head, Link } from '@inertiajs/react';
import { Form, Input, Button, Checkbox, Typography, Alert } from 'antd';
import { MailOutlined, LockOutlined } from '@ant-design/icons';

const { Title } = Typography;

export default function Login({ status, canResetPassword, userKey, success, error }) {
    const { data, setData, post, processing, errors, reset } = useForm({
        email: '',
        password: '',
        remember: false,
    });

    const submit = (e) => {
        e.preventDefault();
        post(route('login'), {
            onFinish: () => reset('password'),
        });
    };

    return (
        <>
            <Head title="Log in" />
            <div className="max-w-md mx-auto mt-10 p-6 bg-white shadow-md rounded-lg">
                <Title level={2} className="text-center">Đăng Nhập</Title>

                {status && (
                    <Alert message={status} type="success" showIcon className="mb-4" />
                )}

                {success && (
                    <Alert message={success} type="success" showIcon className="mb-4" />
                )}

                {error && (
                    <Alert message={error} type="error" showIcon className="mb-4" />
                )}

                <Form
                    layout="vertical"
                    onSubmitCapture={submit}
                >
                    <Form.Item
                        label="Email"
                        validateStatus={errors.email && "error"}
                        help={errors.email}
                    >
                        <Input
                            prefix={<MailOutlined className="site-form-item-icon" />}
                            type="email"
                            name="email"
                            value={data.email}
                            onChange={(e) => setData('email', e.target.value)}
                        />
                    </Form.Item>

                    <Form.Item
                        label="Mật Khẩu"
                        validateStatus={errors.password && "error"}
                        help={errors.password}
                    >
                        <Input.Password
                            prefix={<LockOutlined className="site-form-item-icon" />}
                            name="password"
                            value={data.password}
                            onChange={(e) => setData('password', e.target.value)}
                        />
                    </Form.Item>

                    <Form.Item>
                        <Checkbox
                            name="remember"
                            checked={data.remember}
                            onChange={(e) => setData('remember', e.target.checked)}
                        >
                            Nhớ tôi
                        </Checkbox>
                    </Form.Item>

                    {userKey && (
                        <div className="mt-4">
                            <Typography.Text type="secondary">
                                Key người dùng: <strong>{userKey}</strong>
                            </Typography.Text>
                        </div>
                    )}

                    <Form.Item>
                        <div className="flex items-center justify-between">
                            {canResetPassword && (
                                <Link href={route('password.request')} className="text-sm text-gray-600 underline hover:text-gray-900">
                                    Quên mật khẩu?
                                </Link>
                            )}

                            <Button type="primary" htmlType="submit" loading={processing}>
                                Đăng Nhập
                            </Button>
                        </div>
                    </Form.Item>
                </Form>
            </div>
        </>
    );
}
