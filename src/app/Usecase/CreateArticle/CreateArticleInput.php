<?php
namespace App\UseCase\CreateArticle;

use App\Domain\ValueObject\Article\ArticleTitle;
use App\Domain\ValueObject\Article\ArticleContents;

final class CreateArticleInput
{
    private ArticleTitle $title;
    private ArticleContents $contents;

    public function __construct(ArticleTitle $title, ArticleContents $contents)
    {
        $this->title = $title;
        $this->contents = $contents;
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
