@component('mail::message')
# Thông báo thay đổi Email 

Xin chào {{ $user->name }},<br>

Chúng tôi nhận được yêu cầu đổi email liên kết cho tài khoản của bạn. 
Với email được thay thế là: {{ $user->email }}.<br>
Nếu bạn không thực hiện yêu cầu này, vui lòng liên hệ với chúng tôi ngay lập tức 
qua số điện thoại - 203923794 hoặc địa chỉ email - 030237210209@st.buh.edu.vn.<br>

Trân trọng,

{{ config('app.name') }} Team

@endcomponent
