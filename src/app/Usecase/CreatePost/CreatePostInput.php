<?php
namespace App\UseCase\CreatePost;

use App\Domain\ValueObject\Post\PostTitle;
use App\Domain\ValueObject\Post\PostContents;

final class CreatePostInput
{
    private PostTitle $title;
    private PostContents $contents;

    public function __construct(PostTitle $title, PostContents $contents)
    {
        $this->title = $title;
        $this->contents = $contents;
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
