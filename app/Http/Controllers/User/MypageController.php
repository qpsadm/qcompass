<?php
// app/Http/Controllers/User/MypageController.php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Announcement;
use Illuminate\Support\Facades\Auth;

class MypageController extends Controller
{
    public function index()
    {
        $user = Auth::user(); // ログイン中のユーザーを取得

        // もしユーザー詳細も必要なら取得
        $user_details = $user->details ?? null; // 例: hasOneリレーションで取得

        return view('user.mypage.mypage', compact('user', 'user_details'));
    }
}
