<?php
namespace App\Usecase\FindArticle;

use App\Adapter\QueryService\ArticleQueryService;
use App\Domain\Entity\Article;

final class FindArticleInteractor
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
        // idに指定がない場合はfalse判定
        if (is_null($this->input->id())) {
            return new FindArticleOutput(false, self::NOT_FOUND_MESSAGE);
        }
        $article = $this->findArticle();
        if (!$this->existsArticle($article)) {
            return new FindArticleOutput(false, self::NOT_FOUND_MESSAGE);
        }

        return new FindArticleOutput(true, self::COMPLETE_MESSAGE, $article);
    }

    /**
     * 記事の取得
     * @return Article|null
     */
    private function findArticle(): ?Article
    {
        return $this->articleQueryService->findById($this->input->id());
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
