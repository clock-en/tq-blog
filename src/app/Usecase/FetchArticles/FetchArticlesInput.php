<?php
namespace App\UseCase\FetchArticles;

use App\Domain\ValueObject\Order;
use App\Domain\ValueObject\Article\ArticleKeyword;

final class FetchArticlesInput
{
    /** @var Order */
    private Order $order;
    /** @var ArticleKeyword */
    private ArticleKeyword $keyword;

    /**
     * @param Order
     * @param ArticleKeyword
     */
    public function __construct(Order $order, ArticleKeyword $keyword)
    {
        $this->order = $order;
        $this->keyword = $keyword;
    }

    /**
     * @return Order
     */
    public function order(): Order
    {
        return $this->order;
    }

    /**
     * @return ArticleKeyword
     */
    public function keyword(): ArticleKeyword
    {
        return $this->keyword;
    }
}
