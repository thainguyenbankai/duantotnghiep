import React, { useState } from 'react';
import axios from 'axios';
axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken;

const WarrantySupportForm = () => {
  const [formData, setFormData] = useState({
    email: '',
    productName: '',
    requestPurpose: '',
  });

  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormData({ ...formData, [name]: value });
  };

  const handleSubmit = (e) => {
    e.preventDefault();

    // Gửi yêu cầu POST tới API Laravel
    axios.post('api/send-warranty-support', formData)
      .then(response => {
        alert('Gửi thành công');
      })
      .catch(error => {
        console.error('Có lỗi xảy ra khi gửi email', error);
        alert('Gửi thất bại');
      });
  };

  return (
    <>
      <div className="flex p-6">
        <div className="flex-1">
          <img
            src="https://bizweb.dktcdn.net/100/517/497/themes/956320/assets/img_tu_van.jpg?1728126696498"
            alt="Support"
            className="w-full h-auto"
          />
        </div>
        <div className="flex-1 pl-6">
          <h2 className="text-2xl font-bold mb-4">Hỗ trợ bảo hành</h2>
          <form onSubmit={handleSubmit} className="space-y-4">
            <div>
              <label className="block">Thông tin liên hệ của khách hàng:</label>
              <input
                type="email"
                name="email"
                placeholder="Email"
                value={formData.email}
                onChange={handleChange}
                required
                className="w-full border border-gray-300 rounded p-2"
              />
            </div>
            <div>
              <label className="block">Thông tin về sản phẩm</label>
              <input
                type="text"
                name="productName"
                placeholder="Tên sản phẩm"
                value={formData.productName}
                onChange={handleChange}
                required
                className="w-full border border-gray-300 rounded p-2 mb-2"
              />
            </div>

            <div>
              <label className="block">Nội dung chi tiết</label>
              <textarea
                name="requestPurpose"
                placeholder="Nêu rõ yêu cầu của bạn"
                value={formData.requestPurpose}
                onChange={handleChange}
                required
                className="w-full border border-gray-300 rounded p-2 h-24"
              />
            </div>
            <button type="submit" className="w-full bg-blue-500 text-white rounded p-2 hover:bg-blue-600">
              Gửi thông tin
            </button>
          </form>
        </div>
      </div>
    </>
  );
};

export default WarrantySupportForm;
