<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\KhachThue;
use App\Models\ChuXe;
use Illuminate\Support\Facades\Storage;

class ClientAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('client.auth.login');
    }
    public function showRegisterForm()
    {
        return view('client.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'role' => 'required|in:khach,chu_xe',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'required|string|max:15', 
            'img_gplx_truoc' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'img_gplx_sau' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->role == 'khach') {

            if (KhachThue::where('Email', $request->email)->exists()) {
                return back()->withErrors(['email' => 'Email này đã được sử dụng!'])->withInput();
            }

            $pathTruoc = null;
            $pathSau = null;
            if ($request->hasFile('img_gplx_truoc')) {
                $pathTruoc = $request->file('img_gplx_truoc')->store('bang_lai', 'public');
            }

            if ($request->hasFile('img_gplx_sau')) {
                $pathSau = $request->file('img_gplx_sau')->store('bang_lai', 'public');
            }

            $user = KhachThue::create([
                'Ho_Ten' => $request->name,
                'Email' => $request->email,
                'password' => Hash::make($request->password),
                'So_Dien_Thoai' => $request->phone,      
                'CCCD' => $request->cccd,
                'Dia_Chi' => $request->address,
                'So_GPLX' => $request->gplx,
                'Hang_Bang_Lai' => $request->hang_bang_lai,
                'Ngay_Cap_GPLX' => $request->ngay_cap,
                'Ngay_Het_Han_GPLX' => $request->ngay_het_han,
                'Anh_Bang_Lai_Truoc' => $pathTruoc,
                'Anh_Bang_Lai_Sau' => $pathSau,
            ]);

            Auth::guard('khach')->login($user);
            return redirect()->route('home')->with('success', 'Đăng ký thành công!');
        }
        elseif ($request->role == 'chu_xe') {

            if (ChuXe::where('Email_CX', $request->email)->exists()) {
                return back()->withErrors(['email' => 'Email đối tác đã tồn tại!'])->withInput();
            }

            $user = ChuXe::create([
                'Ten_CX' => $request->name,
                'Email_CX' => $request->email,
                'password' => Hash::make($request->password),               
                'SoDT_CX' => $request->phone,            
                'DiaChi_CX' => $request->address,
                'SoTKNH_CX' => $request->banking_number,
                'Trang_Thai' => 'ChoDuyet'
            ]);

            Auth::guard('chu_xe')->login($user);
            return redirect()->route('partner.profile')->with('success', 'Chào mừng đối tác mới!');
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'role' => 'required|in:khach,chu_xe',
        ]);

        if ($request->role == 'khach') {
            if (Auth::guard('khach')->attempt(['Email' => $request->email, 'password' => $request->password])) {
                $request->session()->regenerate();
                return redirect()->intended(route('home'));
            }
        } elseif ($request->role == 'chu_xe') {
            if (Auth::guard('chu_xe')->attempt(['Email_CX' => $request->email, 'password' => $request->password])) {
                $request->session()->regenerate();
                return redirect()->intended(route('partner.profile'));
            }
        }

        return back()->withErrors(['email' => 'Thông tin đăng nhập không chính xác.'])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        if (Auth::guard('khach')->check()) Auth::guard('khach')->logout();
        if (Auth::guard('chu_xe')->check()) Auth::guard('chu_xe')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('client.login');
    }
}
