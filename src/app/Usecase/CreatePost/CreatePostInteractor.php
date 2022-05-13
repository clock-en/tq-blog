<?php
namespace App\UseCase\CreatePost;

use App\Adapter\Repository\BlogRepository;
use App\Domain\ValueObject\Post\NewPost;
use App\Domain\ValueObject\User\UserId;
use App\Utils\Session;

final class CreatePostInteractor
{
    const COMPLETE_MESSAGE = '登録が完了しました。';

    private CreatePostInput $input;
    private BlogRepository $blogRepository;

    public function __construct(CreatePostInput $input)
    {
        $this->input = $input;
        $this->blogRepository = new BlogRepository();
    }

    /**
     * インタラクタ実行
     * @return CreatePostOutput
     */
    public function handle(): CreatePostOutput
    {
        $session = Session::getInstance();
        $user = $session->getUser();
        $userId = new UserId($user['id']);
        $this->create($userId);
        return new CreatePostOutput(true, self::COMPLETE_MESSAGE);
    }

    /**
     * 新規記事作成
     * @param UserId $userId
     */
    private function create(UserId $userId): void
    {
        $this->blogRepository->create(
            new NewPost(
                $userId,
                $this->input->title(),
                $this->input->contents()
            )
        );
    }
}
