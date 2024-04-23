<form method="post" style="background-color:rgba(0,0,0,0.3);"  enctype="multipart/form-data" 
    class="box top-0 start-0 end-0 bottom-0 position-fixed z-10"
>
    @csrf
    <div style="width:fit-content;height:fit-content;" class="position-relative bg-white m-auto rounded-4 py-2 px-4 mt-10">
        <div role="button" class="quit position-absolute top-0 end-0 mt-2 me-2">
            <i class="fa-solid fa-circle-xmark text-danger h3"></i>
        </div>
        <p class="text-black h6 p-4 fw-bold text-start border-bottom">
            THÊM MỚI
        </p>
        
        <div class="crud">
            <input type="hidden" name="form-post" value="">
            <input type="hidden" name="form-get" value="{{ old('form-post') ?? '' }}">
            <div>
                <label>Tên tài khoản</label>
                <input type="text" value="" name="user_name">
                <span class="error hidden text-danger fs-xs">
                    @error('user_name')
                    {{ $message }}
                    @enderror
                </span>
            </div>
            <div>
                <label>Email đăng ký</label>
                <input type="text" value="" name="email">
                <span class="error hidden text-danger fs-xs">
                    @error('email')
                    {{ $message }}
                    @enderror
                </span>
            </div>
            <div>
                <label>Mật khẩu</label>
                <input type="text" value="" name="password">
                <span class="error hidden text-danger fs-xs">
                    @error('password')
                    {{ $message }}
                    @enderror
                </span>
            </div>
            <div class="w-50">
                <label>Quyền truy cập</label>
                <select name="role">
                    <option value="11105">User</option>
                    <option value="11101">Admin</option>
                    <option value="11102">Manager</option>
                    <option value="11103">Staff</option>
                    <option value="11105">Editor</option>
                </select>
                <span class="error hidden text-danger fs-xs">
                    @error('role')
                    {{ $message }}
                    @enderror
                </span>
            </div>
        </div>

        <button type="submit" name="action" value="add" class="d-block p-3 text-decoration-none my-2 w-50 mx-auto bg-primary text-white fs-6 fw-bold text-center rounded-5">
            LƯU
        </button>
    </div>
</form>