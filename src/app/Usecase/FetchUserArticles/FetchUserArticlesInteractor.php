<?php
namespace App\UseCase\FetchUserArticles;

use App\Adapter\QueryService\ArticleQueryService;
use App\Domain\Entity\Article;

final class FetchUserArticlesInteractor
{
    const EMPTY_MESSAGE = '記事が一件もありませんでした。';
    const COMPLETE_MESSAGE = '記事を取得しました。';

    /** @var FetchUserArticlesInput */
    private FetchUserArticlesInput $input;
    /** @var ArticleQueryService */
    private ArticleQueryService $articleQueryService;

    /**
     * @param FetchUserArticlesInput $input
     */
    public function __construct(FetchUserArticlesInput $input)
    {
        $this->input = $input;
        $this->articleQueryService = new ArticleQueryService();
    }

    /**
     * インタラクタ実行
     * @return FetchUserArticlesOutput
     */
    public function handle(): FetchUserArticlesOutput
    {
        $articles = $this->fetchArticles();
        if (!$this->existsArticle($articles)) {
            return new FetchUserArticlesOutput(false, self::EMPTY_MESSAGE);
        }

        return new FetchUserArticlesOutput(
            true,
            self::COMPLETE_MESSAGE,
            $articles
        );
    }

    /**
     * 記事一覧の取得
     * @return ArrayObject<Article>|null
     */
    private function fetchArticles()
    {
        return $this->articleQueryService->fetchArticlesByUserId(
            $this->input->userId()
        );
    }

    /**
     * 記事の存在チェック
     * @param ArrayObject<Article>|null $articles
     * @return bool
     */
    private function existsArticle(?array $articles)
    {
        return !is_null($articles);
    }
}
