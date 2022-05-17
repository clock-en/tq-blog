<?php
namespace App\UseCase\FetchArticles;

use App\Adapter\QueryService\ArticleQueryService;
use App\Domain\Entity\Article;
use App\UseCase\FetchArticle\FetchArticlesOutput;

final class SignInInteractor
{
    const EMPTY_MESSAGE = '記事が一件もありませんでした。';
    const COMPLETE_MESSAGE = '記事を取得しました。';

    private ArticleQueryService $articleQueryService;

    public function __construct()
    {
        $this->articleQueryService = new ArticleQueryService();
    }

    /**
     * インタラクタ実行
     * @return FetchArticlesOutput
     */
    public function handle(): FetchArticlesOutput
    {
        $articles = $this->fetchArticles();

        if (!$this->existsArticle($articles)) {
            return new FetchArticlesOutput(false, self::EMPTY_MESSAGE);
        }

        return new FetchArticlesOutput(true, self::COMPLETE_MESSAGE, $articles);
    }

    /**
     * 記事一覧の取得
     * @return Article[]|null
     */
    private function fetchArticles(): ?array
    {
        return $this->articleQueryService->fetchArticles();
    }

    /**
     * 記事の存在チェック
     * @param Article[]|null $articles
     * @return bool
     */
    private function existsArticle(?array $articles)
    {
        return !is_null($articles);
    }
}
