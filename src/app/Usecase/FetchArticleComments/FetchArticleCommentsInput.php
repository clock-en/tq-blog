<?php
namespace App\Usecase\FetchArticleComments;

use App\Domain\ValueObject\Article\ArticleId;

final class FetchArticleCommentsInput
{
    /** @var ArticleId */
    private ArticleId $articleId;

    /**
     * @param ArticleId
     */
    public function __construct(ArticleId $articleId)
    {
        $this->articleId = $articleId;
    }

    /**
     * @return ArticleId
     */
    public function articleId(): ArticleId
    {
        return $this->articleId;
    }
}
