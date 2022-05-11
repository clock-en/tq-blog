<?php
namespace App\UseCase\CreatePost;

use App\Adapter\Repository\BlogRepository;
use App\Domain\ValueObject\Post\NewPost;
use App\Domain\ValueObject\User\UserId;

final class CreatePostInteractor
{
    const COMPLETE_MESSAGE = '登録が完了しました。';

    private UserId $userId;
    private CreatePostInput $input;
    private BlogRepository $blogRepository;

    public function __construct(UserId $userId, CreatePostInput $input)
    {
        $this->userId = $userId;
        $this->input = $input;
        $this->blogRepository = new BlogRepository();
    }

    /**
     * インタラクタ実行
     * @return CreatePostOutput
     */
    public function handle(): CreatePostOutput
    {
        $this->create();
        return new CreatePostOutput(true, self::COMPLETE_MESSAGE);
    }

    /**
     * 新規記事作成
     */
    private function create(): void
    {
        $this->blogRepository->create(
            new NewPost(
                $this->userId,
                $this->input->title(),
                $this->input->contents()
            )
        );
    }
}
