import React, { useEffect } from 'react';
import InputError from '@/Components/InputError';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import GuestLayout from '@/Layouts/GuestLayout';
import { Head, useForm } from '@inertiajs/react';
import { message } from 'antd';

export default function ForgotPassword({ status }) {
    const { data, setData, post, processing, errors } = useForm({
        email: '',
    });

    useEffect(() => {
        if (status) {
            message.success(status); // Hiển thị thông báo thành công nếu có status
        }
        if (errors.email) {
            message.error('Có lỗi xảy ra, vui lòng kiểm tra lại email của bạn.'); // Hiển thị thông báo lỗi nếu có lỗi email
        }
    }, [status, errors.email]);

    const submit = (e) => {
        e.preventDefault();

        post(route('password.email'), {
            onSuccess: () => {
                message.success('Chúng tôi đã gửi link lấy lại mật khẩu đến email của bạn.'); // Thông báo thành công
            },
            onError: () => {
                message.error('Không thể gửi link lấy lại mật khẩu. Vui lòng thử lại.'); // Thông báo lỗi
            },
        });
    };

    return (
        <GuestLayout>
            <Head title="Forgot Password" />

            <div className="mb-4 text-sm text-gray-600">
                Bạn quên mật khẩu, hãy nhập email của bạn vào để kiểm tra, chúng tôi sẽ gửi 1 link cho bạn để lấy lại mật khẩu.
            </div>

            {status && (
                <div className="mb-4 text-sm font-medium text-green-600">
                    {status}
                </div>
            )}

            <form onSubmit={submit}>
                <TextInput
                    id="email"
                    type="email"
                    name="email"
                    value={data.email}
                    className="mt-1 block w-full"
                    isFocused={true}
                    onChange={(e) => setData('email', e.target.value)}
                />

                <InputError message={errors.email} className="mt-2" />

                <div className="mt-4 flex items-center justify-end">
                    <PrimaryButton className="ms-4" disabled={processing}>
                        Lấy lại mật khẩu
                    </PrimaryButton>
                </div>
            </form>
        </GuestLayout>
    );
}
