@component('mail::message')
# Đặt lại Mật khẩu

Xin chào,
Bạn nhận được email này vì chúng tôi đã nhận được yêu cầu đặt lại mật khẩu cho tài khoản của bạn.

@component('mail::button', ['url' => url('/reset-password/' . $token)])
Đặt lại Mật khẩu
@endcomponent

Nếu bạn không yêu cầu đặt lại mật khẩu, vui lòng bỏ qua email này.


Trân trọng,
{{ config('app.name') }} Team
@endcomponent

