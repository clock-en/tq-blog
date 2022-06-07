<?php
namespace App\Adapter\ViewModel;

use App\Domain\Entity\Article;
use App\Domain\Entity\Comment;
use App\UseCase\FindArticle\FindArticleOutput;
use App\UseCase\FetchArticleComments\FetchArticleCommentsOutput;

final class DetailViewModel
{
    /** @var FindArticleOutput */
    private FindArticleOutput $articleOutput;
    /** @var FetchArticleCommentsOutput */
    private FetchArticleCommentsOutput $commentOutput;

    /**
     * @param FindArticleOutput $output
     */
    public function __construct(
        FindArticleOutput $articleOutput,
        FetchArticleCommentsOutput $commentOutput
    ) {
        $this->articleOutput = $articleOutput;
        $this->commentOutput = $commentOutput;
    }

    /**
     * Web用ViewModelを返却
     * @return array{isSuccess: bool, message: string, articles: array|null}
     */
    public function convertToWebView(): array
    {
        return [
            'isSuccess' => $this->articleOutput->isSuccess(),
            'message' => $this->articleOutput->message(),
            'article' => $this->createArticleForWebView(
                $this->articleOutput->article()
            ),
            'comments' => $this->createCommentsForWebView(
                $this->commentOutput->comments()
            ),
        ];
    }

    /**
     * view用のArticleを生成
     * @param Article|null
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

    /**
     * view用のCommentリストを生成
     * @param ArrayObject<Comment>|null $comments
     * @return ArrayObject<{id: int, commenterName: string, contents: string, createdAt: createdAt }>|null
     */
    private function createCommentsForWebView($comments): ?array
    {
        if (is_null($comments)) {
            return null;
        }
        $output = [];
        foreach ($comments as $comment) {
            $output[] = [
                'id' => $comment->id()->value(),
                'commenterName' => $comment->commenterName()->value(),
                'contents' => $comment->contents()->value(),
                'createdAt' => $comment->createdAt()->value(),
            ];
        }
        return $output;
    }
}
