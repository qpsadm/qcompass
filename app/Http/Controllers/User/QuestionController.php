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
        $keyword = $request->query('keyword');

        $questions = Question::query()->where('is_show', 1);

        if ($tagId) {
            $questions->where('tag_id', $tagId);
        }

        if ($keyword) {
            $questions->where(function ($q) use ($keyword) {
                $q->where('content', 'like', "%{$keyword}%")
                    ->orWhere('answer', 'like', "%{$keyword}%");
            });
        }

        $questions = $questions->orderBy('updated_at', 'desc')
            ->paginate(5)
            ->appends(['tag' => $tagId, 'keyword' => $keyword]);

        $tags = Tag::all();

        // 複数単語に分割してビューに渡す
        $keywords = $keyword ? preg_split('/\s+/', $keyword) : [];

        return view('user.question.questions_list', compact('questions', 'tags', 'keyword', 'keywords'));
    }
}
