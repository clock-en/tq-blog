<?php
namespace App\UseCase\FetchArticleComments;

use App\Adapter\QueryService\CommentQueryService;
use App\Domain\Entity\Article;

final class FetchArticleCommentsInteractor
{
    const EMPTY_MESSAGE = '記事が一件もありませんでした。';
    const COMPLETE_MESSAGE = '記事を取得しました。';

    /** @var FetchArticleCommentsInput */
    private FetchArticleCommentsInput $input;
    /** @var CommentQueryService */
    private CommentQueryService $commentQueryService;

    /**
     * @param FetchArticleCommentsInput $input
     */
    public function __construct(FetchArticleCommentsInput $input)
    {
        $this->input = $input;
        $this->commentQueryService = new CommentQueryService();
    }

    /**
     * インタラクタ実行
     * @return FetchArticleCommentsOutput
     */
    public function handle(): FetchArticleCommentsOutput
    {
        $comments = $this->fetchComments();
        if (!$this->existsComment($comments)) {
            return new FetchArticleCommentsOutput(false, self::EMPTY_MESSAGE);
        }

        return new FetchArticleCommentsOutput(
            true,
            self::COMPLETE_MESSAGE,
            $comments
        );
    }

    /**
     * 記事一覧の取得
     * @return ArrayObject<Article>|null
     */
    private function fetchComments()
    {
        return $this->commentQueryService->fetchCommentsByArticleId(
            $this->input->articleId()
        );
    }

    /**
     * 記事の存在チェック
     * @param ArrayObject<Article>|null $articles
     * @return bool
     */
    private function existsComment(?array $comments)
    {
        return !is_null($comments);
    }
}
