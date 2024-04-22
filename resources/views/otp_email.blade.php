@component('mail::message')
# Mã OTP

Xin chào,

Dưới đây là mã OTP để xác thực tài khoản của bạn:

**Mã OTP:** {{ $user->confirmation_code }}
**Hết hạn lúc:** {{ $user->confirmation_code_expired_in }}

Vui lòng sử dụng mã OTP này để hoàn tất quá trình xác thực tài khoản của bạn.

Nếu bạn không thực hiện yêu cầu này, vui lòng bỏ qua email này hoặc liên hệ với chúng tôi ngay lập tức.

Trân trọng,

{{ config('app.name') }} Team

@endcomponent
