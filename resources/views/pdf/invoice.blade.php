<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <title>Hóa đơn bán hàng</title>
    <style type="text/css">
        * {
            font-family: 'Times New Roman', sans-serif;
        }
        table{
            font-size: 13px;
        }
        tfoot tr td{
            font-weight: bold;
            font-size: 13px;
            padding: 4px;
        }
        .gray {
            background-color: lightgray;
        }
        .logo {
            color: rgb(31, 132, 90);
            font-size: 36px;
        }
    </style>

</head>
    <body>

    <table width="100%">
        <tr>
            <td width="50%" valign="top"><h1 class="logo">L O G O</h1></td>
            <td align="right">
                <h3>Cửa hàng mỹ phẩm LOGO</h3>
                <p style="margin-top:6px;">
                    56 Đ. Hoàng Diệu 2, Linh Chiểu, Thủ Đức, Thành phố Hồ Chí Minh <br>
                    0302372102 <br>
                    030237210209@st.buh.edu.vn<br>
                </p>
            </td>
        </tr>

    </table>

    <table width="100%" style="margin-top:6px;">
        <tr>
            <td><strong>From:</strong> LOGO - Nhân Viên</td>
            <td><strong>To:</strong> {{ $data->full_name }}</td>
        </tr>

    </table>

    <br/>

    <table width="100%" style="text-align:center;">
        <thead style="background-color: lightgray;">
        <tr>
            <th>#</th>
            <th>Tên Sản Phẩm</th>
            <th>Số Lượng</th>
            <th>Đơn Giá</th>
            <th>Tổng</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($data->orderdetail as $row)
        <tr>
            <th scope="row">{{ $loop->index }}</th>
            <td style="padding:4px;">{{ $row->product->product_name }}</td>
            <td align="right">{{ number_format($row->quantity, 0, '', ',') }}</td>
            <td align="right">{{ number_format($row->product->newprice, 0, '', ',') }}</td>
            <td align="right">{{ number_format($row->quantity * $row->product->unit_price, 0, '', ',') }}</td>
        </tr>
        @endforeach
        </tbody>

        <tfoot>
            <tr>
                <td colspan="3"></td>
                <td align="right">Tạm tính</td>
                <td align="right">{{ number_format($data->amount, 0, '', ',') }} VNĐ</td>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td align="right">Giảm giá</td>
                <td align="right">{{ number_format($data->discountcost, 0, '', ',') }} VNĐ</td>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td align="right">Phí vận chuyển</td>
                <td align="right">{{ number_format($data->shipping_fee, 0, '', ',') }} VNĐ</td>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td align="right">Thành tiền</td>
                <td align="right" class="gray">{{ number_format($data->total, 0, '', ',') }} VNĐ</td>
            </tr>
        </tfoot>
    </table>

    </body>
</html>