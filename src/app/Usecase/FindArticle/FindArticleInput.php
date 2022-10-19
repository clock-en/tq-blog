<?php
namespace App\Usecase\FindArticle;

use App\Domain\ValueObject\Article\ArticleId;

final class FindArticleInput
{
    /** @var ArticleId|null */
    private ?ArticleId $id;

    /**
     * @param ArticleId|null $id
     */
    public function __construct(?ArticleId $id)
    {
        $this->id = $id;
    }

    /**
     * @return ArticleId|null
     */
    public function id(): ?ArticleId
    {
        return $this->id;
    }
}
