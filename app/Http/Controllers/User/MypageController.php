<?php
// app/Http/Controllers/User/MypageController.php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Announcement;

class MypageController extends Controller
{
    public function index()
    {
        $user = auth()->user(); // ログインユーザー
        $user_details = $user->details; // UserDetail取得
        $reports = $user->reports()->pluck('date')->toArray(); // 日報提出日だけ取得
        $announcements = Announcement::latest()->get();
        // $memos = $user->memos()->latest()->get();

        return view('user.mypage.mypage', compact(
            'user',
            'user_details',
            'reports',
            'announcements',
            // 'memos'
        ));
    }
}
