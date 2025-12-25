<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DonThue;
use Carbon\Carbon;

class LichXeController extends AdminBaseController
{
    public function index(Request $request)
    {
        if ($request->has('start') && $request->has('end')) {

            $rangeStart = Carbon::parse($request->start)->toDateTimeString();
            $rangeEnd = Carbon::parse($request->end)->toDateTimeString();

           
            $data = DonThue::where('Ngay_Bat_Dau', '<', $rangeEnd)
                ->where('Ngay_Ket_Thuc', '>', $rangeStart)
                ->where('Trang_Thai', '!=', 'DaHuy')
                ->with('xe', 'khachThue')
                ->get();

            $events = [];

            foreach ($data as $item) {
                $color = '#858796';
                if ($item->Trang_Thai == 'ChoDuyet') $color = '#f6c23e'; 
                else if ($item->Trang_Thai == 'DaDuyet') $color = '#36b9cc'; 
                else if ($item->Trang_Thai == 'DaDatCoc') $color = '#4e73df'; 
                else if (in_array($item->Trang_Thai, ['DangDiChuyen', 'DaGiaoXe', 'DangHoatDong'], true)) $color = '#1cc88a'; 
                else if (in_array($item->Trang_Thai, ['HoanThanh', 'DaTraXe'], true)) $color = '#5a5c69';
                else if ($item->Trang_Thai == 'QuaHan') $color = '#343a40'; 

                $events[] = [
                    'id' => $item->Ma_DT,
                    'title' => '#' . $item->Ma_DT,
                    'start' => $item->Ngay_Bat_Dau,
                    'end' => $item->Ngay_Ket_Thuc,
                    'backgroundColor' => $color,
                    'borderColor' => $color,
                    'textColor' => '#ffffff',
                    'url' => route('don-thue.show', $item->Ma_DT)
                ];
            }

            return response()->json($events)
                ->header('Cache-Control', 'no-cache, no-store, must-revalidate');
        }

        return view('admin.lich_xe.index');
    }
}
