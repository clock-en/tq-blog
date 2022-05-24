<?php
namespace App\UseCase\FindArticle;

use App\Domain\ValueObject\Article\ArticleId;

final class FindArticleInput
{
    /** @var ArticleId */
    private ArticleId $id;

    /**
     * @param ArticleId $id
     */
    public function __construct(ArticleId $id)
    {
        $this->id = $id;
    }

    /**
     * @return ArticleId
     */
    public function id(): ArticleId
    {
        return $this->id;
    }
}
