<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CmsBlock;
use App\Models\CmsPage;
use App\Models\Xe; 
use App\Models\PhanLoaiXe; 
use App\Models\TienIch;
use App\Models\DanhMucThongSo;
use App\Models\User;
use App\Models\Promotion;
use Illuminate\Support\Facades\Schema;

class HomeController extends Controller
{
    private function getMasterAdmin()
    {
        return User::query()
            ->where(function ($q) {
                $q->where('id', 1)
                    ->orWhere('VaiTro', 'Master Admin')
                    ->orWhere('VaiTro', 'master admin')
                    ->orWhere('VaiTro', 'LIKE', '%master%');
            })
            ->orderByRaw('CASE WHEN id = 1 THEN 0 ELSE 1 END')
            ->orderBy('id')
            ->first();
    }

    private function loadCmsBlocksForSlugs(array $slugs)
    {
        if (!Schema::hasTable('cms_pages') || !Schema::hasTable('cms_blocks')) {
            return collect();
        }

        $pages = CmsPage::query()
            ->where('is_active', true)
            ->whereIn('slug', $slugs)
            ->orderByRaw('FIELD(slug,' . collect($slugs)->map(fn($s) => "'" . addslashes($s) . "'")->implode(',') . ')')
            ->get(['id', 'slug']);

        if ($pages->isEmpty()) {
            return collect();
        }

        $pageIds = $pages->pluck('id')->values();
        $pageIdOrder = $pageIds->implode(',');

        return CmsBlock::query()
            ->active()
            ->whereIn('page_id', $pageIds)
            ->orderByRaw('FIELD(page_id,' . $pageIdOrder . ')')
            ->orderBy('type')
            ->orderBy('sort_order')
            ->get()
            ->groupBy('type');
    }

    private function getSupportAdmins()
    {
        return User::query()
            ->where('id', '!=', 1)
            ->whereNotNull('VaiTro')
            ->where(function ($q) {
                $q->whereIn('VaiTro', [
                    'CSKH',
                    'ChamSocKhachHang',
                    'ChamSocKH',
                    'Chăm sóc khách hàng',
                    'Chăm Sóc Khách Hàng',
                    'Cham soc khach hang',
                ])
                    ->orWhere(function ($q2) {
                        $q2->where('VaiTro', 'LIKE', '%cham%')
                            ->where('VaiTro', 'LIKE', '%khach%');
                    });
            })
            ->orderBy('name')
            ->get();
    }

    // 1. TRANG CHỦ
    public function index()
    {
        $loaiXes = PhanLoaiXe::query()->orderBy('Ten_PLXe')->get();
        $cmsHomeBlocks = $this->loadCmsBlocksForSlugs(['home', 'index', 'about']);
        $xes = Xe::with(['phanLoaiXe', 'thongSo.hopSo', 'thongSo.nhienLieu'])
            ->withCount('danhGias as so_luong_danh_gia')
            ->withAvg('danhGias as diem_trung_binh', 'So_Sao')
            ->where('TrangThai_Xe', 'SanSang')
            ->whereRaw(
                '(select count(*) from danh_gias dg where dg.Ma_Xe = xes.Ma_Xe and dg.Trang_Thai = ?) > 0',
                ['HienThi']
            )
            ->whereRaw(
                '(select avg(dg.So_Sao) from danh_gias dg where dg.Ma_Xe = xes.Ma_Xe and dg.Trang_Thai = ?) >= ?',
                ['HienThi', 4]
            )
            ->orderByDesc('diem_trung_binh')
            ->orderByDesc('so_luong_danh_gia')
            ->orderByDesc('created_at')
            ->take(6)
            ->get();

        $supportAdmins = $this->getSupportAdmins();
        $masterAdmin = $this->getMasterAdmin();

        $activePromotions = collect();
        if (Schema::hasTable('promotions')) {
            $activePromotions = Promotion::displayable()
                ->orderByDesc('start_at')
                ->orderByDesc('created_at')
                ->get();
        }

        return view('index', compact('xes', 'supportAdmins', 'masterAdmin', 'loaiXes', 'cmsHomeBlocks', 'activePromotions'));
    }

    public function vehicle(Request $request)
    {
        $statusColumn = Schema::hasColumn('xes', 'TrangThai_Xe') ? 'TrangThai_Xe' : 'TrangThai_Xe';

        $xesQuery = Xe::with(['phanLoaiXe', 'thongSo.hopSo', 'thongSo.nhienLieu'])
            ->withCount('danhGias as so_luong_danh_gia')
            ->withAvg('danhGias as diem_trung_binh', 'So_Sao')
            ->where($statusColumn, 'SanSang');

        $plxe = $request->query('plxe');
        $q = trim((string) $request->query('q', ''));

        if (!empty($plxe)) {
            $xesQuery->where('Ma_PLXe', $plxe);
        }

        if ($q !== '') {
            $xesQuery->where('Ten_Xe', 'LIKE', '%' . $q . '%');
        }

        $xes = $xesQuery->orderBy('created_at', 'desc')->get();

        return view('vehicle', compact('xes'));
    }

    public function detail($id)
    {
        $xe = Xe::with([
            'phanLoaiXe',
            'chuXe',
            'thongSo.hopSo',
            'thongSo.nhienLieu',
            'tienIches',
            'danhGias',
        ])->findOrFail($id);

        $relatedCars = Xe::with(['phanLoaiXe'])
            ->where('Ma_PLXe', $xe->Ma_PLXe)
            ->where('Ma_Xe', '!=', $xe->Ma_Xe) 
            ->where('TrangThai_Xe', 'SanSang')
            ->take(3)
            ->get();

        return view('cardetail', compact('xe', 'relatedCars'));
    }

    public function about()
    {
        $cmsAboutBlocks = $this->loadCmsBlocksForSlugs(['about']);
        $supportAdmins = $this->getSupportAdmins();

        return view('about', compact('cmsAboutBlocks', 'supportAdmins'));
    }
    public function blog()
    {
        return view('blog');
    }
    public function team()
    {
        $cmsTeamBlocks = $this->loadCmsBlocksForSlugs(['team']);
        $supportAdmins = $this->getSupportAdmins();

        return view('team', compact('supportAdmins', 'cmsTeamBlocks'));
    }
    public function contact()
    {
        $loaiXes = PhanLoaiXe::all();
        $tienIches = TienIch::all();
        $dsNhienLieu = DanhMucThongSo::nhienLieu()->get();
        $dsHopSo = DanhMucThongSo::hopSo()->get();

        return view('contact', compact('loaiXes', 'tienIches', 'dsNhienLieu', 'dsHopSo'));
    }
}
