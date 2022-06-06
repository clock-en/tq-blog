<?php
namespace App\UseCase\UpdateArticle;

use App\Domain\ValueObject\Article\ArticleId;
use App\Domain\ValueObject\Article\ArticleTitle;
use App\Domain\ValueObject\Article\ArticleContents;

final class UpdateArticleInput
{
    /** @var ArticleId */
    private ArticleId $id;
    /** @var ArticleTitle */
    private ArticleTitle $title;
    /** @var ArticleContents */
    private ArticleContents $contents;

    /**
     * @param ArticleId $id
     * @param ArticleTitle $title
     * @param ArticleContents $contents
     */
    public function __construct(
        ArticleId $id,
        ArticleTitle $title,
        ArticleContents $contents
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->contents = $contents;
    }

    /**
     * @return ArticleId
     */
    public function id(): ArticleId
    {
        return $this->id;
    }

    /**
     * @return ArticleTitle
     */
    public function title(): ArticleTitle
    {
        return $this->title;
    }

    /**
     * @return ArticleContents
     */
    public function contents(): ArticleContents
    {
        return $this->contents;
    }
}
