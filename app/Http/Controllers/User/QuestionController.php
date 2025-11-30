<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Tag;

class QuestionController extends Controller
{
    public function index(Request $request)
    {
        $tagId = $request->query('tag');

        // 公開されている質問だけ取得
        $questions = Question::query()->where('is_show', 1);

        // タグで絞り込み
        if ($tagId) {
            $questions->where('tag_id', $tagId);
        }

        // 作成日の新しい順で取得
        $questions = $questions->orderBy('created_at', 'desc')->paginate(5);

        // タグ一覧を取得
        $tags = Tag::all();

        return view('user.question.questions_list', [
            'questions' => $questions,
            'tags' => $tags,
        ]);
    }
}
