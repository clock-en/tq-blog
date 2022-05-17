<?php
namespace App\Adapter\QueryService;

use App\Infrastructure\Dao\ArticleSqlDao;
use App\Domain\Entity\User;
use App\Domain\ValueObject\User\UserId;
use App\Domain\ValueObject\User\UserName;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\HashedPassword;

final class ArticleQueryService
{
    private ArticleSqlDao $articleDao;

    public function __construct()
    {
        $this->articleDao = new ArticleSqlDao();
    }

    /**
     * ユーザーを検索し、取得したレコードをUserエンティティとして返却
     * @return User|null
     */
    public function fetchPosts(): ?User
    {
        $articleMapper = $this->blogDao->fetchPosts();
        return $this->existsPost($articleMapper)
            ? new User(
                new UserId($userMapper['id']),
                new UserName($userMapper['name']),
                new Email($userMapper['email']),
                new HashedPassword($userMapper['password'])
            )
            : [];
    }

    /**
     * PostEntityの配列を生成
     * @param array
     * @return array
     */
    public function createPostEntities(array $articles): array
    {
        $output = [];
        foreach ($articles as $article) {
            $output[] = $article;
        }
        return $output;
    }

    /**
     * ユーザーの存在チェック
     * @param array|null $articleMapper
     * @return bool
     */
    private function existsPost(?array $articleMapper): bool
    {
        return !is_null($articleMapper);
    }
}
