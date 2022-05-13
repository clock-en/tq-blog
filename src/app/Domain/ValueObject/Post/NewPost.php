<?php
namespace App\Domain\ValueObject\Post;

use App\Domain\ValueObject\User\UserId;

final class NewPost
{
    private UserId $userId;
    private PostTitle $title;
    private PostContents $contents;

    public function __construct(
        UserId $userId,
        PostTitle $title,
        PostContents $contents
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
     * @return PostTitle
     */
    public function title(): PostTitle
    {
        return $this->title;
    }

    /**
     * @return PostContents
     */
    public function contents(): PostContents
    {
        return $this->contents;
    }
}
