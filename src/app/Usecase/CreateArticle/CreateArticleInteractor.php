<?php
namespace App\UseCase\CreateArticle;

use App\Adapter\Repository\ArticleRepository;
use App\Domain\ValueObject\Article\NewArticle;
use App\Domain\ValueObject\User\UserId;
use App\Utils\Session;

final class CreateArticleInteractor
{
    const COMPLETE_MESSAGE = '登録が完了しました。';

    private CreateArticleInput $input;
    private ArticleRepository $articleRepository;

    public function __construct(CreateArticleInput $input)
    {
        $this->input = $input;
        $this->articleRepository = new ArticleRepository();
    }

    /**
     * インタラクタ実行
     * @return CreateArticleOutput
     */
    public function handle(): CreateArticleOutput
    {
        $session = Session::getInstance();
        $user = $session->getUser();
        $userId = new UserId($user['id']);
        $this->create($userId);
        return new CreateArticleOutput(true, self::COMPLETE_MESSAGE);
    }

    /**
     * 新規記事作成
     * @param UserId $userId
     */
    private function create(UserId $userId): void
    {
        $this->articleRepository->create(
            new NewArticle(
                $userId,
                $this->input->title(),
                $this->input->contents()
            )
        );
    }
}
