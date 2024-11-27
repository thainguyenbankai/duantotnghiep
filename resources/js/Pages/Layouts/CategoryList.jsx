import React from 'react';

const CategoryList = ({ categorys }) => {
const showcategory = (id) => {
window.location.href = `/category/${id}`;
};
return (
<div className="container">
    <div className="category">
        <h1 className="category__title">Danh sách danh mục</h1>
        <div className="category__grid">
            {categorys.map((category) => (
            <div key={category.id} className="product-card category__item cursor-pointer" onClick={()=>
                showcategory(category.id)} >
                <div className="product-card__content">
                    <img className="product-card__image"
                        src="https://pisces.bbystatic.com/image2/BestBuy_US/images/products/6487/6487406_sd.jpg"
                        alt="background" />
                    <h2 className="product-card__name">{category.name}</h2>
                </div>
            </div>
            ))}
        </div>
    </div>
</div>
);
};

export default CategoryList;