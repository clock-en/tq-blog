<?php
namespace App\Domain\ValueObject\Comment;

use App\Domain\ValueObject\User\UserId;
use App\Domain\ValueObject\Article\ArticleId;

final class NewComment
{
    /** @var UserId */
    private UserId $userId;
    /** @var ArticleId */
    private ArticleId $articleId;
    /** @var CommenterName */
    private CommenterName $commenterName;
    /** @var CommentContents */
    private CommentContents $contents;

    /**
     * @param UserId $userId
     * @param ArticleId $articleId
     * @param CommenterName $commenterName
     * @param CommentContents $contents
     */
    public function __construct(
        UserId $userId,
        ArticleId $articleId,
        CommenterName $commenterName,
        CommentContents $contents
    ) {
        $this->userId = $userId;
        $this->articleId = $articleId;
        $this->commenterName = $commenterName;
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
     * @return ArticleId
     */
    public function articleId(): ArticleId
    {
        return $this->articleId;
    }

    /**
     * @return CommenterName
     */
    public function commenterName(): CommenterName
    {
        return $this->commenterName;
    }

    /**
     * @return CommentContents
     */
    public function contents(): CommentContents
    {
        return $this->contents;
    }
}
