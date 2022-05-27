<?php
namespace App\Adapter\ViewModel;

use App\Domain\Entity\Article;
use App\UseCase\FindArticle\FindArticleOutput;

final class MyArticleDetailViewModel
{
    /** @var FindArticleOutput */
    private FindArticleOutput $output;

    /**
     * @param FindArticleOutput $output
     */
    public function __construct(FindArticleOutput $output)
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
            'article' => $this->createArticleForWebView(
                $this->output->article()
            ),
        ];
    }

    /**
     * view用のArticleを生成
     * @param ArrayObject<Article>|null
     * @return {id, int, title: string, contents: string }|null
     */
    private function createArticleForWebView($article): ?array
    {
        if (is_null($article)) {
            return null;
        }
        return [
            'id' => $article->id()->value(),
            'title' => $article->title()->value(),
            'contents' => $article->contents()->value(),
            'createdAt' => $article->createdAt()->value(),
        ];
    }
}
