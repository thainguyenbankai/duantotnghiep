import React from 'react';
import HeaderLayout from './Header';
import FooterLayout from './Footer';

const DefaultLayout = ({ children }) => {
    return (
        <>
            <HeaderLayout />
            <main>{children}</main>
            <FooterLayout />
        </>
    );
};

export default DefaultLayout;
