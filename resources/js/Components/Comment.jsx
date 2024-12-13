import React, { useState, useEffect } from "react";
import { usePage, Link } from '@inertiajs/react';
import { message, Modal, Rate, Input, Button } from 'antd';
const csrfToken = document.head.querySelector('meta[name="csrf-token"]');

if (csrfToken) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken.content;
}
const Comment = ({ product }) => {
    const { props } = usePage();
    const user = props.auth.user;

    const [showModal, setShowModal] = useState(false);
    const [selectedStars, setSelectedStars] = useState(0);
    const [comment, setComment] = useState('');
    const [ratings, setRatings] = useState([]);  // Khởi tạo với mảng rỗng
    const [comments, setComments] = useState([]); // Khởi tạo với mảng rỗng

    const imageUrl = product.image ? `/storage/${product.image}` : '/default-image.jpg';
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    const handleOpenModal = () => {
        setShowModal(true);
    };

    const handleCloseModal = () => {
        setShowModal(false);
        setSelectedStars(0);
        setComment('');
    };



    const handleSubmitComment = async () => {
        if (!user) {
            message.error('Vui lòng đăng nhập để gửi đánh giá!');
            return;
        }

        if (selectedStars === 0 || comment.trim() === '') {
            message.error('Vui lòng chọn số sao và nhập bình luận!');
            return;
        }

        try {
            const response = await fetch('/api/comments', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({
                    rating: selectedStars,
                    review_text: comment,
                    user_id: user.id,
                    product_id: product.id,
                }),
            });

            if (!response.ok) {
                throw new Error('Failed to submit comment');
            }

            const data = await response.json();
            message.success(`Đánh giá ${selectedStars} sao đã được gửi!`);
            handleCloseModal();
            fetchRatings();
            fetchComments();
        } catch (error) {
            console.error('Error:', error);
            message.error('Có lỗi xảy ra khi gửi đánh giá. Vui lòng thử lại.');
        }
    };
    const fetchComments = async () => {
        try {
            const response = await fetch(`/api/comments/${product.id}`);
            if (!response.ok) {
                throw new Error('Failed to fetch comments');
            }
            const data = await response.json();
            setComments(data || []); // Đảm bảo data là mảng
        } catch (error) {
            console.error('Error:', error);
        }
    };
    const fetchRatings = async () => {
        try {
            const response = await fetch(`/api/comments/${product.id}`);
            const data = await response.json();
            setRatings(data.ratings || []);  // Đảm bảo data.ratings là mảng
        } catch (error) {
            console.error('Error fetching ratings:', error);
        }
    };


    useEffect(() => {
        fetchRatings();
        fetchComments();
    }, [product.id]);

    return (
        <div className="container mt-12">
            <h2 className="text-xl font-bold mb-4">Đánh giá sản phẩm</h2>
            <div className="flex">
                <div className="w-1/2 p-4">
                    <span className="text-sm">{comments.length} Bình luận</span> {/* Hiển thị tổng số bình luận */}
                </div>

                <div className="w-1/2 p-4 flex flex-col gap-4">
                    {ratings.length > 0 && ratings.map((rating, index) => (
                        <div key={index} className="flex justify-between items-center w-full">
                            <div className="w-1/3 flex flex-col items-center">
                                <span className="text-yellow-500 flex">
                                    {'★'.repeat(rating.stars).padEnd(5, '☆')}
                                </span>
                                <span className="text-sm">{rating.stars} sao</span>
                            </div>
                            <div className="w-1/3 flex flex-col items-center">
                                <input type="range" className="w-full h-2 bg-gray-200 rounded-lg" min="0" max="10" step="0.1"
                                    value={(rating.count / 10) * 10} disabled />
                                <span className="text-sm">Điểm đánh giá</span>
                            </div>
                            <div className="w-1/3 flex flex-col items-center">
                                <span className="text-sm">{rating.count} đánh giá</span>
                            </div>
                        </div>
                    ))}

                    {comments.length > 0 && comments.map((comment) => (
                        <div key={comment.id} className="border-b border-gray-300 pb-4 mb-4">
                            <div className="flex justify-between">
                                <span className="font-semibold">{comment.username}</span>
                                <span className="text-yellow-500">
                                    {'★'.repeat(comment.rating).padEnd(5, '☆')}
                                </span>
                            </div>
                            <p className="text-gray-700">{comment.review_text}</p>
                        </div>
                    ))}
                </div>
            </div>

            {user ? (
                <Button className="mt-4" type="primary" onClick={handleOpenModal}>
                    Gửi đánh giá sản phẩm
                </Button>
            ) : (
                <div className="mt-4 text-red-500 text-center">
                    Vui lòng{" "}
                    <Link href="/login" className="text-blue-500 font-semibold underline hover:text-blue-700">
                        đăng nhập
                    </Link>{" "}
                    để gửi đánh giá!
                </div>
            )}

            <div className="mt-8 p-6 border border-gray-300 rounded-lg shadow-lg bg-white">
                <h3 className="text-lg font-bold mb-4">Bình luận</h3>
                {comments.map((comment) => (
                    <div key={comment.id} className="border-b border-gray-300 pb-4 mb-4">
                        <div className="flex justify-between">
                            <span className="font-semibold">{comment.username}</span>
                            <span className="text-yellow-500">
                                {'★'.repeat(comment.rating).padEnd(5, '☆')}  {/* Hiển thị số sao */}
                            </span>
                        </div>
                        <p className="text-gray-700">{comment.review_text}</p>
                    </div>
                ))}
            </div>


            <Modal visible={showModal} onCancel={handleCloseModal} footer={null} width={600}>
                <div className="flex mb-4">
                    <img src={imageUrl} alt={product.name} className="w-1/3 h-auto object-cover mr-4" />
                    <h2 className="text-xl font-semibold">{product.name}</h2>
                </div>
                <h2 className="text-xl font-bold mb-4">Gửi Đánh Giá</h2>
                <Rate allowHalf value={selectedStars} onChange={setSelectedStars} className="mb-4" />
                <Input.TextArea rows={4} value={comment} onChange={(e) => setComment(e.target.value)}
                    placeholder="Nhập đánh giá của bạn"
                    className="mb-4"
                />
                <div className="flex justify-end gap-2">
                    <Button onClick={handleCloseModal} className="bg-gray-300 text-gray-700">
                        Hủy
                    </Button>
                    <Button onClick={handleSubmitComment} type="primary">
                        Gửi
                    </Button>
                </div>
            </Modal>
        </div>
    );
};
export default Comment;