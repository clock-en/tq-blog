<?php
namespace App\Adapter\Repository;

use App\Infrastructure\Dao\ArticleSqlDao;
use App\Domain\ValueObject\Article\NewArticle;
use App\Domain\Entity\Article;

final class ArticleRepository
{
    private ArticleSqlDao $articleDao;

    public function __construct()
    {
        $this->articleDao = new ArticleSqlDao();
    }

    /**
     * 新規記事の作成
     * @param NewArticle $article
     */
    public function create(NewArticle $article): void
    {
        $this->articleDao->create($article);
    }

    /**
     * 記事の修正
     * @param Article $article
     */
    public function update(Article $article): void
    {
        $this->articleDao->update($article);
    }
}
