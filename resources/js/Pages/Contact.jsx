import React, { useState } from 'react';
axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken;

const ContactForm = () => {
  const [formData, setFormData] = useState({
    name: '',
    email: '',
    phone: '',
    message: '',
  });

  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormData({ ...formData, [name]: value });
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    console.log(formData);
  };

  return (
    <>
      <div className="container mx-auto p-6">
        <h2 className="text-3xl font-bold text-center mb-6">Thông tin liên hệ</h2>
        <div className="flex flex-col md:flex-row md:justify-between mb-6">
          <div className="md:w-1/3 mb-4 md:mb-0">
            <h3 className="text-xl font-semibold">Địa chỉ</h3>
            <p className="text-gray-600">266 Đội Cấn, Ba Đình, Hà Nội</p>
          </div>
          <div className="md:w-1/3 mb-4 md:mb-0">
            <h3 className="text-xl font-semibold">Email</h3>
            <p className="text-gray-600">support@sapovn.com</p>
          </div>
          <div className="md:w-1/3 mb-4 md:mb-0">
            <h3 className="text-xl font-semibold">Hotline</h3>
            <p className="text-gray-600">1900 6750</p>
          </div>
        </div>
        <div className="mb-6">
          <iframe
            title="Google Map"
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3723.106092059526!2d105.83415531538443!3d21.02942058600777!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ab9b15caeb61%3A0x4af8f1e8886c8b9b!2sSapo%20POS!5e0!3m2!1sen!2s!4v1630986755747!5m2!1sen!2s"
            width="100%"
            height="300"
            className="border rounded"
            allowFullScreen=""
            loading="lazy"
          ></iframe>
        </div>
        <form onSubmit={handleSubmit} className="space-y-4">
          <div>
            <label className="block">Họ và tên</label>
            <input
              type="text"
              name="name"
              placeholder="Họ và tên"
              value={formData.name}
              onChange={handleChange}
              required
              className="w-full border border-gray-300 rounded p-2"
            />
          </div>
          <div>
            <label className="block">Email</label>
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
            <label className="block">Điện thoại</label>
            <input
              type="tel"
              name="phone"
              placeholder="Điện thoại"
              value={formData.phone}
              onChange={handleChange}
              required
              className="w-full border border-gray-300 rounded p-2"
            />
          </div>
          <div>
            <label className="block">Tin nhắn</label>
            <textarea
              name="message"
              placeholder="Nội dung tin nhắn"
              value={formData.message}
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
    </>

  );
};

export default ContactForm;