import React from 'react';
import { Head } from '@inertiajs/react';

const PageTitle = ({ title }) => {
    return (
        <>
            <Head title={title} />
            <div className="container__pagetitle container mx-auto">
                <div className="container banner__title">
                    <div className="pagetitle">
                        <h1 className="banner__title pt-4 text-3xl font-bold text-center">{title}</h1>
                        <span>Trang chủ / {title}</span>
                    </div>
                </div>
            </div>
        </>
    );
};

export default PageTitle;
