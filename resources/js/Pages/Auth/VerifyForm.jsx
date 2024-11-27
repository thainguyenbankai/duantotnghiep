import React from 'react';
import { Head, useForm } from '@inertiajs/react';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';

export default function VerifyForm({ status, email }) {
    const { data, setData, post, processing, errors } = useForm({
        email: sessionStorage.getItem('email') || '', // Fetch email from session
        code: '',
    });

    const submit = (e) => {
        e.preventDefault();

        post(route('auth.verify'), {
            data: {
                email: data.email,
                code: data.code,
            },
            onFinish: () => setData('code', ''), // Reset verification code
            onError: (error) => console.log(error), // Handle error
        });
    };

    return (
        <>
            <Head title="Xác minh tài khoản" />
            <div className="max-w-md mx-auto mt-10 p-6 bg-white shadow-md rounded-lg">
                <h2 className="text-2xl font-bold text-center mb-6">Xác Minh Tài Khoản</h2>

                {status && (
                    <div className="mb-4 text-sm font-medium text-green-600" role="alert">
                        {status}
                    </div>
                )}

                <form onSubmit={submit}>
                    <input type="hidden" name="email" value={data.email} />

                    <div>
                        <InputLabel htmlFor="code" value="Mã Xác Minh" />

                        <TextInput
                            id="code"
                            type="text"
                            name="code"
                            value={data.code}
                            className="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            onChange={(e) => setData('code', e.target.value)}
                        />

                        <InputError message={errors.code} className="mt-2" />
                    </div>

                    <div className="mt-4 flex items-center justify-end">
                        <PrimaryButton className="ml-4" disabled={processing}>
                            Xác Minh
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </>
    );
}