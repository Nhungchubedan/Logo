<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewEmailMail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Date;

use App\Models\Account;
use App\Models\Image;

class AccountController extends Controller
{
    public function index() {
        $data = Account::all();
        return view('admin.account', ['data' => $data]);
    }

    public function store(Request $request) {
        if ($request->action == 'update') {
            $role = $request->role;
            $user = Account::where('id_user', $request->id_user)->first();
            if (isset($user)) {
                $user->update(['id_role' => $role]);
                toastr()->success('Thay đổi quyền truy cập thành công!');
                return response()->json(['message' => $user]);
            }
            toastr()->error('Có lỗi xảy ra!');
            return response()->json(['message' => $user]);
        } else {
            $validator = Validator::make($request->all(), [
                'user_name' => 'required',
                'email' => 'required|email|unique:user',  
                'password' => 'required|min:8',  
            ]);
            $form = $request->input('form-post');
        
            if ($validator->fails()) {
    
                return redirect()->back()->withErrors($validator->errors())->withInput(['form-post' => $form]);
    
            } else {
                Account::create([
                    'user_name' => $request->input('user_name'),  
                    'email'     => $request->input('email'),  
                    'id_role'   => $request->input('role'),  
                    'password'  => Hash::make($request->input('password')),
                    'id_image'  => 1,
                    'confirm'   => 1
                ]);
                toastr()->success('Thêm mới tài khoản thành công.');
            }
            return redirect()->route('admin.account.index');

        }
    }

    public function detail() {
        $userId = Auth::user()->id_user;
        $account = Account::where('id_user', $userId)->first();
        return view('user.account.index', [
            'account' => $account
        ]);
    }

    public function modify(Request $request) {
        $account = Auth::user();
        $oldEmail = $account->email;

        if ($request->isMethod('post')) {
        
            $validator = Validator::make($request->all(), [
                'username' => 'required|min:2|max:20', 
                'email' => 'required|email',  
                'password' => 'required|password',
            ]);
            
            if (!Hash::check($request->input('password'), $account->password)) {
                $validator->errors()->add('password', 'Mật khẩu không chính xác!');
            }

            if ($request->input('email') !== $oldEmail) {
                $userExists = Account::where('email', $request->input('email'))->where('provider','system')->exists();
                if ($userExists) {
                    return back()->withErrors(['isExisted' => 'Email đã tồn tại!']);
                }
            }
        
        
            if ($validator->fails()) {
                
                return back()->withErrors($validator->errors());

            } else {
                $account->update([
                    'user_name' => $request->input('username'),
                    'email' => $request->input('email'),
                ]);

                if ($request->file('avatar')) {
                    $currentImage = $account->id_image;
                    $avatar = $request->file('avatar');
                    $fileName = uniqid('', true) . '.' . $avatar->getClientOriginalExtension(); 

                    $image = Image::create([
                        'image_url' => $fileName,
                        'size' => $avatar->getSize(),
                    ]);
                    $avatar->move('img/', $fileName);

                    $account->update(['id_image' => $image->id_image]);

                    if ($currentImage !== 1 && $currentImage !== null) { 
                        $record = Image::find($currentImage);
                        $record->delete();
                        unlink('img/'.$record->image_url);
                    }
                }
                $account->save();
                Auth::logout();

                toastr()->success('Cập nhập thông tin thành công! Vui lòng đăng nhập lại.');
                Mail::to($account->email)->send(new NewEmailMail($account));

                return redirect()->route('login');

            }
        }


        return view('user.account.modify', [
            'account' => $account    
        ]);
    }

    public function info(Request $request) {
        $user = Auth::user();
        $info = $user->info;
    
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'fullname' => 'required|max:20', 
                'phone' => 'required|numeric',  
                'address' => 'required|max:100',
            ]);
        
            if ($validator->fails()) {
                return back()->withErrors($validator->errors());
            } else {
                $provinceCode = $request->input('province');
                $districtCode = $request->input('district');
                $communeCode = $request->input('commune');

                $arr = $this->getAddress($provinceCode, $districtCode, $communeCode);
                
                if ($info) {
                    $info->update([
                        'full_name'     => $request->input('fullname'),
                        'phone'         => $request->input('phone'),
                        'province'      => $arr[0],
                        'district'      => $arr[1],
                        'commune'       => $arr[2],
                        'type'          => $request->input('type'),
                        'detail_address' => $request->input('address'),
                    ]);
                    $info->save();
                } else {
                    $info = Info::create([
                        'id_user'       => $user->id_user,
                        'full_name'     => $request->input('fullname'),
                        'phone'         => $request->input('phone'),
                        'province'      => $arr[0],
                        'district'      => $arr[1],
                        'commune'       => $arr[2],
                        'type'          => $request->input('type'),
                        'detail_address' => $request->input('address'),
                    ]);
                    $info->save();
                }
                toastr()->success('Cập nhập địa chỉ giao hàng mặc định thành công!');
                return redirect()->route('account');
            }
        }

        $provinceJSON = json_decode(file_get_contents('../resources/json/province.json'))->data->data;

        $address = $info ? $this->fetchAddress($info) : null;
        
        return view('user.account.info', [
            'info' => $info,
            'address' => $address,
            'province' => $provinceJSON
        ]);
    }

    public function password(Request $request) {
        if ($request->isMethod('post')) {
            $user = Auth::user();
        
            $validator = Validator::make($request->all(), [
                'current_password' => 'required|min:8|current_password', 
                'new_password' => 'required|min:8|confirmed',  
                'new_password_confirmation' => 'required',
            ]);
        
            if (!Hash::check($request->input('current_password'), $user->password)) {
                $validator->errors()->add('current_password', 'Mật khẩu hiện tại không chính xác');
            }
        
            if ($validator->fails()) {
                return back()->withErrors($validator->errors());
            } else {
                $newPassword = Hash::make($request->input('new_password'));
        
                $user->update([
                    'password' => $newPassword,
                ]);
        
                toastr()->success('Đổi mạt khẩu thành công!');
                return redirect()->route('account');
            }
        }
        
        return view('user.account.password');
    }

    private function fetchAddress($info) {
        $province = json_decode(file_get_contents('../resources/json/province.json'))->data->data;
        $district = json_decode(file_get_contents('../resources/json/district.json'))->data->data;
        $commune = json_decode(file_get_contents('../resources/json/commune.json'))->data->data;
        $provinceCode = null;
        $districtCode = null;

        foreach ($province as $p) {
            if ($info->province === $p->name) {
                $provinceCode = $p->code;
                foreach ($district as $d) {
                    if ($info->district === $d->name_with_type) {
                        $districtCode = $d->code;
                        break;
                    }
                }
                break;
            }
        }
        $districtFilter = [];
        foreach ($district as $d) {
            if ($d->parent_code == $provinceCode) {
                $districtFilter[] = $d;
            }
        }
        $communeFilter = [];
        foreach ($commune as $c) {
            if ($c->parent_code == $districtCode) {
                $communeFilter[] = $c;
            }

        }

        return [
            'province' => $province,
            'district' => $districtFilter,
            'province_code' => $provinceCode,
            'district_code' => $districtCode,
            'commune'  => $communeFilter
        ];

    }

    private function getAddress($provinceCode, $districtCode, $communeCode) {
        $province = json_decode(file_get_contents('../resources/json/province.json'))->data->data;
        $district = json_decode(file_get_contents('../resources/json/district.json'))->data->data;
        $commune = json_decode(file_get_contents('../resources/json/commune.json'))->data->data;

        foreach ($province as $p) {
            if ($p->code === $provinceCode) {
                $provinceName = $p->name;
                break;
            }
        }
        foreach ($district as $d) {
            if ($d->code === $districtCode) {
                $districtName = $d->name_with_type;
                break;
            }
        }
        foreach ($commune as $c) {
            if ($c->code === $communeCode) {
                $communeName = $c->name_with_type;
                break;
            }
        }

        return [$provinceName, $districtName, $communeName];
    } 

    public function setting() {
        $userId = Auth::user()->id_user;
        $account = Account::where('id_user', $userId)->first();
        return view('admin.account.index', [
            'account' => $account
        ]);
    }

    public function adminModify(Request $request) {
        $account = Auth::user();
        $oldEmail = $account->email;

        if ($request->isMethod('post')) {
        
            $validator = Validator::make($request->all(), [
                'username' => 'required|min:2|max:20', 
                'email' => 'required|email',  
                'password' => 'required|password',
            ]);
            
            if (!Hash::check($request->input('password'), $account->password)) {
                $validator->errors()->add('password', 'Mật khẩu không chính xác!');
            }

            if ($request->input('email') !== $oldEmail) {
                $userExists = Account::where('email', $request->input('email'))->where('provider','system')->exists();
                if ($userExists) {
                    return back()->withErrors(['isExisted' => 'Email đã tồn tại!']);
                }
            }
        
        
            if ($validator->fails()) {
                
                return back()->withErrors($validator->errors());

            } else {
                $account->update([
                    'user_name' => $request->input('username'),
                    'email' => $request->input('email'),
                ]);

                if ($request->file('avatar')) {
                    $currentImage = $account->id_image;
                    $avatar = $request->file('avatar');
                    $fileName = uniqid('', true) . '.' . $avatar->getClientOriginalExtension(); 

                    $image = Image::create([
                        'image_url' => $fileName,
                        'size' => $avatar->getSize(),
                    ]);
                    $avatar->move('img/', $fileName);

                    $account->update(['id_image' => $image->id_image]);

                    if ($currentImage !== 1 && $currentImage !== null) { 
                        $record = Image::find($currentImage);
                        $record->delete();
                        unlink('img/'.$record->image_url);
                    }
                }
                $account->save();
                Auth::logout();

                toastr()->success('Cập nhập thông tin thành công! Vui lòng đăng nhập lại.');
                Mail::to($account->email)->send(new NewEmailMail($account));

                return redirect()->route('login');

            }
        }
        return view('admin.account.modify', [
            'account' => $account    
        ]);
    }

    public function adminPassword(Request $request) {
        if ($request->isMethod('post')) {
            $user = Auth::user();
        
            $validator = Validator::make($request->all(), [
                'current_password' => 'required|min:8|current_password', 
                'new_password' => 'required|min:8|confirmed',  
                'new_password_confirmation' => 'required',
            ]);
        
            if (!Hash::check($request->input('current_password'), $user->password)) {
                $validator->errors()->add('current_password', 'Mật khẩu hiện tại không chính xác');
            }
        
            if ($validator->fails()) {
                return back()->withErrors($validator->errors());
            } else {
                $newPassword = Hash::make($request->input('new_password'));
        
                $user->update([
                    'password' => $newPassword,
                ]);
        
                toastr()->success('Đổi mạt khẩu thành công!');
                return redirect()->route('admin.setting');
            }
        }
        
        return view('admin.account.password');
    }
}
