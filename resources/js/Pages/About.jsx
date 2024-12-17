import React from 'react';
import '../../css/abouts.css';

const AboutUs = () => {
  return (
    <>
      <div className="flex flex-col md:flex-row items-center p-6">
        {/* Hình ảnh giới thiệu */}
        <div className="md:w-1/2">
          <img
            src="https://southteam.vn/wp-content/uploads/2021/03/Cong-ty-thiet-ke-web-uy-tin-tai-TPHCM.jpg"
            alt="Magic Shop FPT Polytechnic"
            className="w-full h-auto"
          />
        </div>

        {/* Nội dung giới thiệu */}
        <div className="md:w-1/2 md:pl-6">
          <h2 className="text-3xl font-semibold mt-2">Giới thiệu về Magic Shop </h2>
          <p className="mt-4">
            Magic Shop là một dự án độc đáo được phát triển bởi sinh viên FPT Polytechnic, với sứ mệnh mang đến những sản
            phẩm chất lượng và trải nghiệm mua sắm tuyệt vời cho khách hàng. Được thành lập với tinh thần đổi mới và sáng
            tạo, Magic Shop không chỉ là nơi cung cấp sản phẩm mà còn là nơi kết nối niềm đam mê và giá trị.
          </p>
          <p className="mt-4">
            Với sự hỗ trợ từ đội ngũ giàu kinh nghiệm và nguồn tài nguyên dồi dào tại FPT Polytechnic, Magic Shop cam kết
            mang lại những giá trị vượt trội, đáp ứng mọi nhu cầu từ khách hàng, đồng thời đóng góp vào sự phát triển của
            cộng đồng.
          </p>
          {/* Các đặc điểm nổi bật */}
          <div className="about-us-features grid grid-cols-2 sm:grid-cols-4 gap-6 mt-6">
            <div className="feature">
              <i className="fas fa-user text-blue-500 fa-2x"></i>
              <p className="mt-2">Khách hàng là trọng tâm</p>
            </div>
            <div className="feature">
              <i className="fas fa-check-circle text-blue-500 fa-2x"></i>
              <p className="mt-2">Uy tín hàng đầu</p>
            </div>
            <div className="feature">
              <i className="fas fa-star text-blue-500 fa-2x"></i>
              <p className="mt-2">Sản phẩm chất lượng</p>
            </div>
            <div className="feature">
              <i className="fas fa-lightbulb text-blue-500 fa-2x"></i>
              <p className="mt-2">Sáng tạo không ngừng</p>
            </div>
          </div>
        </div>
      </div>
    </>
  );
};

export default AboutUs;
