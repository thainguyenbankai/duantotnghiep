import { useEffect } from 'react';
import { useForm, Head, Link } from '@inertiajs/react';
import { Form, Input, Button, Checkbox, Typography, message } from 'antd';
import { MailOutlined, LockOutlined } from '@ant-design/icons';

const { Title } = Typography;

export default function Login({ status, canResetPassword }) {
    const { data, setData, post, processing, errors, reset } = useForm({
        email: '',
        password: '',
        remember: false,
    });

    useEffect(() => {
        if (status) {
            message.success(status);
        }
    }, [status]);

    const submit = async (e) => {
        e.preventDefault();

        post(route('login'), {
            onSuccess: (page) => {
                if (page.props.flash?.message) {
                    message.success(page.props.flash.message);
                }
            },
            onError: (errors) => {
                if (errors?.email) {
                    message.error(errors.email);
                } else {
                    message.error('Đăng nhập không thành công. Vui lòng kiểm tra lại.');
                }
            },
        });
    };

    return (
        <>
            <Head title="Log in" />
            <div className="max-w-md mx-auto mt-10 p-6 bg-white shadow-md rounded-lg">
                <Title level={2} className="text-center">Đăng Nhập</Title>

                <Form layout="vertical" onSubmitCapture={submit}>
                    <Form.Item
                        label="Email"
                        validateStatus={errors.email ? "error" : ""}
                        help={errors.email}
                    >
                        <Input
                            prefix={<MailOutlined />}
                            type="email"
                            name="email"
                            value={data.email}
                            onChange={(e) => setData('email', e.target.value)}
                        />
                    </Form.Item>
                    <Form.Item
                        label="Mật Khẩu"
                        validateStatus={errors.password ? "error" : ""}
                        help={errors.password}
                    >
                        <Input.Password
                            prefix={<LockOutlined />}
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
