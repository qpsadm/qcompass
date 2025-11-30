<?php

namespace App\Services;

use App\Models\Quote;
use App\Models\QuotePart;
use App\Models\AuthorPart;

class QuoteService
{
    /**
     * 名言を取得（モード切替）
     */
    public function getQuote($mode = 'mix')
    {
        if ($mode === 'mix') {
            return $this->getMixedQuote();
        }

        return $this->getFullQuote();
    }

    /**
     * ① フル名言を quotes テーブルから取得
     */
    private function getFullQuote()
    {
        $quote = Quote::where('is_show', 1)->inRandomOrder()->first();

        if (!$quote) {
            return [
                'text'   => '名言が登録されていません',
                'author' => '',
            ];
        }

        return [
            'text'   => $quote->quote_full,
            'author' => $quote->author_full,
        ];
    }

    /**
     * ② ABCミックス名言を生成（quote_parts / author_parts）
     */
    private function getMixedQuote()
    {
        $A = $this->getWeightedRandom('A');
        $B = $this->getWeightedRandom('B');
        $C = $this->getWeightedRandom('C');

        $author = $this->getWeightedAuthor();

        return [
            'text' => $A . $B . $C,
            'author' => $author ? "（{$author}）" : '',
        ];
    }

    /**
     * パーツ (A/B/C) を weight に応じてランダム取得
     */
    private function getWeightedRandom($partType)
    {
        $parts = QuotePart::where('part_type', $partType)->get();

        if ($parts->isEmpty()) {
            return '';
        }

        return $parts
            ->flatMap(fn($p) => array_fill(0, $p->weight, $p->text))
            ->shuffle()
            ->first();
    }

    /**
     * 作者パーツをランダム取得
     */
    private function getWeightedAuthor()
    {
        $authors = AuthorPart::get();

        if ($authors->isEmpty()) {
            return '';
        }

        return $authors
            ->flatMap(fn($p) => array_fill(0, $p->weight, $p->text))
            ->shuffle()
            ->first();
    }
}
