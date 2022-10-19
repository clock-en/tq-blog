<?php
namespace App\Usecase\UpdateArticle;

use App\Adapter\Repository\ArticleRepository;
use App\Adapter\QueryService\ArticleQueryService;
use App\Domain\ValueObject\User\UserId;
use App\Domain\Entity\Article;
use App\Utils\Session;

final class UpdateArticleInteractor
{
    const BAD_REQUEST_MESSAGE = '不正な値が送信されました。';
    const COMPLETE_MESSAGE = '修正が完了しました。';

    /** @var UpdateArticleInput */
    private UpdateArticleInput $input;
    /** @var ArticleQueryService */
    private ArticleQueryService $articleQueryService;
    /** @var ArticleRepository */
    private ArticleRepository $articleRepository;

    /**
     * @param UpdateArticleInput $input
     */
    public function __construct(UpdateArticleInput $input)
    {
        $this->input = $input;
        $this->articleQueryService = new ArticleQueryService();
        $this->articleRepository = new ArticleRepository();
    }

    /**
     * インタラクタ実行
     * @return UpdateArticleOutput
     */
    public function handle(): UpdateArticleOutput
    {
        $session = Session::getInstance();
        $user = $session->getUser();
        $userId = new UserId($user['id']);
        $article = $this->findArticle();
        // ユーザーIDと一致しない記事情報を修正リクエストが飛んできた場合は不正とする
        if (
            is_null($article) ||
            $article->userId()->value() !== $userId->value()
        ) {
            return new UpdateArticleOutput(false, self::BAD_REQUEST_MESSAGE);
        }

        // エンティティの内容を修正してUpdate
        $updatedArticle = $article->update(
            $this->input->title(),
            $this->input->contents()
        );
        $this->update($updatedArticle);
        return new UpdateArticleOutput(true, self::COMPLETE_MESSAGE);
    }

    /**
     * 記事修正
     * @param Article $article
     */
    private function update(Article $article): void
    {
        $this->articleRepository->update($article);
    }

    /**
     * 記事の取得
     * @return Article|null
     */
    private function findArticle(): ?Article
    {
        return $this->articleQueryService->findById($this->input->id());
    }
}
