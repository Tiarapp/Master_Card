<?php

namespace Database\Seeders;

use App\Models\UserFeedback;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UserFeedbackSeeder extends Seeder
{
    public function run()
    {
        $feedbacks = [
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'type' => 'suggestion',
                'category' => 'inventory',
                'priority' => 'medium',
                'subject' => 'Saran: Tambah fitur export Excel pada inventory',
                'message' => 'Saya menyarankan untuk menambahkan fitur export data inventory ke format Excel agar memudahkan dalam membuat laporan. Saat ini harus copy paste manual yang cukup merepotkan.',
                'status' => 'resolved',
                'admin_response' => 'Terima kasih atas sarannya. Fitur export Excel telah ditambahkan di halaman inventory.',
                'responded_at' => Carbon::now()->subDays(2),
                'created_at' => Carbon::now()->subDays(7),
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'type' => 'bug_report',
                'category' => 'system',
                'priority' => 'high',
                'subject' => 'Bug: Sistem logout otomatis setelah 5 menit',
                'message' => 'Saya mengalami masalah dimana sistem selalu logout otomatis setelah sekitar 5 menit tidak ada aktivitas. Padahal seharusnya bisa lebih lama. Hal ini sangat mengganggu produktivitas.',
                'status' => 'in_progress',
                'browser_info' => [
                    'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                    'ip_address' => '192.168.1.100'
                ],
                'created_at' => Carbon::now()->subDays(3),
            ],
            [
                'name' => 'Admin User',
                'email' => 'admin@company.com',
                'type' => 'feature_request',
                'category' => 'ui_ux',
                'priority' => 'low',
                'subject' => 'Fitur: Dark mode untuk tampilan',
                'message' => 'Permintaan untuk menambahkan fitur dark mode pada sistem. Ini akan membantu mengurangi kelelahan mata saat bekerja dalam waktu lama, terutama di malam hari.',
                'status' => 'open',
                'created_at' => Carbon::now()->subDays(1),
            ],
            [
                'name' => 'Customer Service',
                'email' => 'cs@company.com',
                'type' => 'complaint',
                'category' => 'reports',
                'priority' => 'urgent',
                'subject' => 'Keluhan: Laporan loading sangat lambat',
                'message' => 'Laporan di halaman dashboard membutuhkan waktu loading yang sangat lama, kadang hingga 30 detik. Ini membuat customer menunggu terlalu lama saat kami sedang melayani mereka.',
                'status' => 'open',
                'created_at' => Carbon::now()->subHours(2),
            ],
            [
                'type' => 'suggestion',
                'category' => 'inventory',
                'priority' => 'medium',
                'subject' => 'Saran: Notification untuk stok rendah',
                'message' => 'Akan sangat membantu jika ada notifikasi otomatis ketika stok barang mencapai batas minimum. Saat ini harus cek manual setiap hari.',
                'status' => 'resolved',
                'admin_response' => 'Fitur notifikasi stok rendah telah diimplementasikan. Anda akan menerima email otomatis setiap pagi jika ada barang dengan stok di bawah minimum.',
                'responded_at' => Carbon::now()->subDays(1),
                'created_at' => Carbon::now()->subDays(5),
            ]
        ];

        foreach ($feedbacks as $feedback) {
            UserFeedback::create($feedback);
        }
    }
}
