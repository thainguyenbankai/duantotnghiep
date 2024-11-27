import { Head } from '@inertiajs/react';
import ProductListHot from './Layouts/ProductList_Hot';
import ProductListNew from './Layouts/ProductList_New';
import Slideshow from '../Components/Carousel';
import VoucherList from './layouts/VoucherList';
import { message } from 'antd';

const Home = ({ products, products_news, errors }) => {
    // Hiển thị thông báo lỗi nếu có
    if (errors && Object.keys(errors).length > 0) {
        Object.values(errors).forEach((error) => {
            message.error(error);
        });
    }

    return (
        <>
            <Slideshow />
            <VoucherList />
            <ProductListHot products={products} />
            <ProductListNew products_news={products_news} />
        </>
    );
};

export default Home;
