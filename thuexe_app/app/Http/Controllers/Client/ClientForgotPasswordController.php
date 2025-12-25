<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\KhachThue;
use App\Models\ChuXe;
use Carbon\Carbon;

class ClientForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('client.auth.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'role' => 'required|in:khach,chu_xe',
        ]);
        if ($request->role == 'khach') {
            $user = KhachThue::where('Email', $request->email)->first();
        } else {
            $user = ChuXe::where('Email_CX', $request->email)->first();
        }

        if (!$user) {
            return back()->withErrors(['email' => 'Email không tồn tại trong hệ thống.']);
        }
        $token = Str::random(64);
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        $link = route('client.password.reset', ['token' => $token, 'email' => $request->email, 'role' => $request->role]);

        return back()->with('resetLink', $link)->with('success', 'Đã tìm thấy tài khoản! Vui lòng bấm vào link bên dưới để đặt lại mật khẩu.');
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('client.auth.reset-password')->with([
            'token' => $token, 
            'email' => $request->email,
            'role' => $request->role
        ]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'role' => 'required|in:khach,chu_xe',
            'password' => 'required|string|min:6|confirmed',
            'token' => 'required'
        ]);

        // Kiểm tra token có hợp lệ không
        $resetRecord = DB::table('password_resets')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$resetRecord) {
            return back()->withErrors(['email' => 'Link đặt lại mật khẩu không hợp lệ hoặc đã hết hạn!']);
        }
        $newPassword = Hash::make($request->password);
        if ($request->role == 'khach') {
            KhachThue::where('Email', $request->email)->update(['password' => $newPassword]);
        } else {
            ChuXe::where('Email_CX', $request->email)->update(['password' => $newPassword]);
        }
        DB::table('password_resets')->where(['email'=> $request->email])->delete();
        return redirect()->route('client.login')->with('success', 'Mật khẩu đã được thay đổi thành công! Hãy đăng nhập ngay.');
    }
}