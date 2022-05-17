<?php
namespace App\Adapter\Repository;

use App\Infrastructure\Dao\ArticleSqlDao;
use App\Domain\ValueObject\Article\NewArticle;

final class ArticleRepository
{
    private ArticleSqlDao $articleDao;

    public function __construct()
    {
        $this->articleDao = new ArticleSqlDao();
    }

    /**
     * 新規ユーザーの作成
     * @param NewArticle $article
     */
    public function create(NewArticle $article): void
    {
        $this->articleDao->create($article);
    }
}
