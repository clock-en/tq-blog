<?php
namespace App\Adapter\Repository;

use App\Infrastructure\Dao\BlogSqlDao;
use App\Domain\ValueObject\Post\NewPost;

final class BlogRepository
{
    private BlogSqlDao $blogDao;

    public function __construct()
    {
        $this->blogDao = new BlogSqlDao();
    }

    /**
     * 新規ユーザーの作成
     * @param NewPost $post
     */
    public function create(NewPost $post): void
    {
        $this->blogDao->create($post);
    }
}
