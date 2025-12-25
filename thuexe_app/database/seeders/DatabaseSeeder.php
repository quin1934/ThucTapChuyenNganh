<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CmsPage;
use App\Models\CmsBlock;

class CmsSeeder extends Seeder
{
    public function run()
    {
        $homePage = CmsPage::create([
            'slug' => 'home',
            'ten_trang' => 'Trang Chủ',
            'is_active' => true
        ]);

        CmsBlock::create([
            'page_id' => $homePage->id,
            'type' => 'hero_slide',
            'title' => 'Chào mừng đến với AutoCar',
            'subtitle' => 'Dịch vụ thuê xe tự lái hàng đầu',
            'content' => 'Trải nghiệm hành trình tuyệt vời với các dòng xe đời mới.',
            'image_path' => 'uploads/hero-1.jpg',
            'cta_text' => 'Đặt xe ngay',
            'cta_url' => '/thue-xe',
            'sort_order' => 1
        ]);
        
        CmsBlock::create([
            'page_id' => $homePage->id,
            'type' => 'hero_slide',
            'title' => 'Ưu đãi mùa hè',
            'subtitle' => 'Giảm giá 20% cho chuyến đi biển',
            'image_path' => 'uploads/hero-2.jpg',
            'cta_text' => 'Xem chi tiết',
            'cta_url' => '/khuyen-mai',
            'sort_order' => 2
        ]);
        
        CmsBlock::create([
            'page_id' => $homePage->id,
            'type' => 'about_intro',
            'title' => 'Về Chúng Tôi',
            'content' => 'AutoCar cung cấp hơn 50+ đầu xe các loại với thủ tục nhanh gọn.',
            'image_path' => 'uploads/about-home.jpg',
            'cta_text' => 'Tìm hiểu thêm',
            'cta_url' => '/ve-chung-toi',
        ]);
    }
}