import React, { useState, useEffect } from 'react';

const CitySelector = () => {
  const [provinces, setProvinces] = useState([]);
  const [districts, setDistricts] = useState([]);
  const [wards, setWards] = useState([]);
  const [selectedProvince, setSelectedProvince] = useState("");
  const [selectedDistrict, setSelectedDistrict] = useState("");
  const [selectedWard, setSelectedWard] = useState("");
  const [loading, setLoading] = useState(false);
  const [shippingFee, setShippingFee] = useState(null);

  const token = "7daf8282-9c90-11ef-aa6c-c69b60b1e6b0";

  const fetchData = async (url, options = {}) => {
    setLoading(true);
    try {
      const res = await fetch(url, options);
      const data = await res.json();
      if (data.code === 200) return data.data;
    } catch (error) {
      console.error("Error fetching data:", error);
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchData("https://online-gateway.ghn.vn/shiip/public-api/master-data/province", {
      headers: { "token": token }
    }).then(data => setProvinces(data || []));
  }, []);

  useEffect(() => {
    if (selectedProvince) {
      fetchData(`https://online-gateway.ghn.vn/shiip/public-api/master-data/district?province_id=${selectedProvince}`, {
        headers: { "token": token }
      }).then(data => setDistricts(data || []));
    } else {
      setDistricts([]);
    }
  }, [selectedProvince]);

  useEffect(() => {
    if (selectedDistrict) {
      fetchData(`https://online-gateway.ghn.vn/shiip/public-api/master-data/ward?district_id=${selectedDistrict}`, {
        headers: { "token": token }
      }).then(data => setWards(data || []));
    } else {
      setWards([]);
    }
  }, [selectedDistrict]);

  const fetchShippingFee = async () => {
    if (!selectedWard || !selectedDistrict || !selectedProvince) return;
    const body = JSON.stringify({
      service_type_id: 2,
      insurance_value: 500000,
      from_district_id: 1542,
      to_district_id: parseInt(selectedDistrict),
      to_ward_code: selectedWard,
      weight: 1500,
      length: 30,
      width: 20,
      height: 10,
    });
    fetchData("https://online-gateway.ghn.vn/shiip/public-api/v2/shipping-order/fee", {
      method: "POST",
      headers: { "token": token, "Content-Type": "application/json" },
      body: body,
    }).then(data => setShippingFee(data ? data.total : null));
  };

  useEffect(() => {
    fetchShippingFee();
  }, [selectedWard, selectedDistrict, selectedProvince]);

  return (
    <div className="flex flex-col items-center p-4 space-y-4">
      <label htmlFor="province">Chọn tỉnh/thành phố:</label>
      <select
        id="province"
        value={selectedProvince}
        onChange={(e) => setSelectedProvince(e.target.value)}
        className="p-2 border border-gray-300 rounded"
      >
        <option value="">Chọn tỉnh/thành phố</option>
        {provinces.map((province) => (
          <option key={province.ProvinceID} value={province.ProvinceID}>
            {province.ProvinceName}
          </option>
        ))}
      </select>

      {selectedProvince && (
        <>
          <label htmlFor="district">Chọn quận/huyện:</label>
          <select
            id="district"
            value={selectedDistrict}
            onChange={(e) => setSelectedDistrict(e.target.value)}
            className="p-2 border border-gray-300 rounded"
          >
            <option value="">Chọn quận/huyện</option>
            {districts.map((district) => (
              <option key={district.DistrictID} value={district.DistrictID}>
                {district.DistrictName}
              </option>
            ))}
          </select>
        </>
      )}

      {selectedDistrict && (
        <>
          <label htmlFor="ward">Chọn xã/phường:</label>
          <select
            id="ward"
            value={selectedWard}
            onChange={(e) => setSelectedWard(e.target.value)}
            className="p-2 border border-gray-300 rounded"
          >
            <option value="">Chọn xã/phường</option>
            {wards.map((ward) => (
              <option key={ward.WardCode} value={ward.WardCode}>
                {ward.WardName}
              </option>
            ))}
          </select>
        </>
      )}

      {loading && <p>Đang tải...</p>}

      {shippingFee && !loading && (
        <div>
          <h3 className="font-semibold">Chi phí vận chuyển:</h3>
          <p>{`Phí vận chuyển: ${shippingFee} VND`}</p>
        </div>
      )}
    </div>
  );
};
export default CitySelector;
