@component('mail::message')
# Thông báo hủy đơn hàng
Xin chào,

Chúng tôi rất làm tiếc khi phải thông báo rằng chúng tôi đã hủy đơn hàng của bạn.
Với lý do:
{!! $emailContent !!}</br>

Cảm ơn bạn đã sử dụng dịch vụ của chúng tôi.

Thanks,<br>
{{ config('app.name') }} Team
@endcomponent
