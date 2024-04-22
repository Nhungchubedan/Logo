<form class="confirm-dialog" action="{{ route($route, $id) }}" method="post">
    @csrf
    @method('delete')
    <div class="dialog rounded-3 relative text-start">
        <i class="fa-solid fa-xmark quit-dialog"></i>
        <h4 class="fs-5 fw-bold w-100 text-danger">Xác nhận</h4>
        <p class="text-black fs-6">Bạn có chắc chắn muốn xóa bản ghi này?</p>
        <div class="mt-4 float-end">
            <button type="submit" class="px-4 py-2 text-white fw-bold bg-danger rounded-5 fs-sm" name="cancel-order">XÁC NHẬN</button>
        </div>
    </div>
</form>