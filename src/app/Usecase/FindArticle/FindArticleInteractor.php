<?php
namespace App\UseCase\FindArticle;

use App\Adapter\QueryService\ArticleQueryService;
use App\Domain\Entity\Article;

final class FetchArticlesInteractor
{
    const NOT_FOUND_MESSAGE = '対象の記事は見つかりませんでした。';
    const COMPLETE_MESSAGE = '記事を取得しました。';

    /** @var FindArticleInput */
    private FindArticleInput $input;
    /** @var ArticleQueryService */
    private ArticleQueryService $articleQueryService;

    /**
     * @param FindArticleInput $input
     */
    public function __construct(FindArticleInput $input)
    {
        $this->input = $input;
        $this->articleQueryService = new ArticleQueryService();
    }

    /**
     * インタラクタ実行
     * @return FindArticleOutput
     */
    public function handle(): FindArticleOutput
    {
        $article = $this->findArticle();
        if (!$this->existsArticle($article)) {
            return new FindArticleOutput(false, self::NOT_FOUND_MESSAGE);
        }

        return new FindArticleOutput(true, self::COMPLETE_MESSAGE, $article);
    }

    /**
     * 記事一覧の取得
     * @return Article|null
     */
    private function findArticle()
    {
        return $this->articleQueryService->findById($this->input->id);
    }

    /**
     * 記事の存在チェック
     * @param Article|null $articles
     * @return bool
     */
    private function existsArticle(?Article $articles)
    {
        return !is_null($articles);
    }
}
