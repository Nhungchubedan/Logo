<form class="confirm-dialog" method="post">
    @csrf
    <div class="dialog relative">
        <i class="fa-solid fa-xmark quit-dialog"></i>
        <h4 class="fs-5 text-success">Xác nhận hủy đơn hàng</h4>
        <p class="text-black fs-6">Bạn có chắc chắn muốn hủy đơn hàng này?</p>
        <div class="mt-4 float-end">
            <input type="hidden" name="id" value="{{ $item->id_order }}">
            <button type="submit" class="btn-yes fs-sm" name="cancel-order">XÁC NHẬN</button>
        </div>
    </div>
</form>