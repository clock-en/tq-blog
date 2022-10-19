<?php
namespace App\Adapter\ViewModel;

use App\Domain\Entity\Article;
use App\Usecase\FetchUserArticles\FetchUserArticlesOutput;

final class MypageViewModel
{
    private FetchUserArticlesOutput $output;

    public function __construct(FetchUserArticlesOutput $output)
    {
        $this->output = $output;
    }

    /**
     * Web用ViewModelを返却
     * @return array{isSuccess: bool, message: string, articles: array|null}
     */
    public function convertToWebView(): array
    {
        return [
            'isSuccess' => $this->output->isSuccess(),
            'message' => $this->output->message(),
            'articles' => $this->createArticlesForWebView(
                $this->output->articles()
            ),
        ];
    }

    /**
     * view用のArticleを生成
     * @param ArrayObject<Article>|null
     * @return array{id, int, title: string, contents: string }|null
     */
    private function createArticlesForWebView($articles): ?array
    {
        if (is_null($articles)) {
            return null;
        }
        $output = [];
        foreach ($articles as $article) {
            $output[] = [
                'id' => $article->id()->value(),
                'title' => $article->title()->value(),
                'contents' => $this->omitContens($article->contents()->value()),
                'createdAt' => $article->createdAt()->value(),
            ];
        }
        return $output;
    }

    /**
     * 記事コンテンツを省略形に変換
     * @param string
     * @return string
     */
    private function omitContens(string $contents): string
    {
        return mb_strimwidth($contents, 0, 15, '…', 'UTF-8');
    }
}
