<?php
namespace App\Domain\ValueObject\Article;

use App\Domain\ValueObject\User\UserId;

final class NewArticle
{
    private UserId $userId;
    private ArticleTitle $title;
    private ArticleContents $contents;

    public function __construct(
        UserId $userId,
        ArticleTitle $title,
        ArticleContents $contents
    ) {
        $this->userId = $userId;
        $this->title = $title;
        $this->contents = $contents;
    }

    /**
     * @return UserId
     */
    public function userId(): UserId
    {
        return $this->userId;
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
