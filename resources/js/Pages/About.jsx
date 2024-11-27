import React from 'react';
import '../../css/abouts.css';
const AboutUs = () => {
  return (
    <>
      <div className="flex flex-col md:flex-row items-center p-6">
        <div className="md:w-1/2">
          <img src="https://bizweb.dktcdn.net/100/517/497/themes/956320/assets/img-section-about.jpg?1728126696498" // Thay
            thế bằng đường dẫn đến hình ảnh của bạn alt="ND Mechanic" className="w-full h-auto" />
        </div>
        <div className="md:w-1/2 md:pl-6">
          <h2 className="text-4xl font-bold">Về chúng tôi</h2>
          <h3 className="text-3xl font-semibold mt-2">Giới thiệu về ND Mechanic</h3>
          <p className="mt-4">
            Chúng tôi luôn hướng đến mục tiêu nâng cao chất lượng dịch vụ và sản phẩm trong ngành cơ khí.
            Điều này, trước đây vốn chỉ nằm trong ý tưởng của ông Toni – nhà sáng lập công ty,
            một chuyên gia cơ khí có nhiều năm kinh nghiệm và tâm huyết với ngành.
            Với niềm đam mê và sự sáng tạo của mình, ông Toni đã thành lập công ty ND Mechanic và mang đến những giải pháp
            cơ khí tiên tiến nhất cho khách hàng.
            Hệ thống của chúng tôi luôn mong muốn được chăm sóc và phục vụ cộng đồng với chất lượng sản phẩm và dịch vụ tốt
            nhất cùng với giá cả hợp lý.
          </p>
          <div className="about-us-features grid grid-cols-2 sm:grid-cols-4 gap-6 mt-6">
            <div className="feature">
              <i className="fas fa-user text-yellow-500 fa-2x"></i>
              <p className="mt-2">Khách hàng là trọng tâm</p>
            </div>
            <div className="feature">
              <i className="fas fa-check-circle text-yellow-500 fa-2x"></i>
              <p className="mt-2">Uy tín hàng đầu</p>
            </div>
            <div className="feature">
              <i className="fas fa-star text-yellow-500 fa-2x"></i>
              <p className="mt-2">Chất lượng tốt</p>
            </div>
            <div className="feature">
              <i className="fas fa-lightbulb text-yellow-500 fa-2x"></i>
              <p className="mt-2">Tư vấn tận tâm</p>
            </div>
          </div>
        </div>
      </div>
    </>
  );
};
export default AboutUs;