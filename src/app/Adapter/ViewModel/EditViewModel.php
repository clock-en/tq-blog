<?php
namespace App\Adapter\ViewModel;

use App\UseCase\UpdateArticle\UpdateArticleOutput;

final class EditViewModel
{
    private UpdateArticleOutput $output;

    public function __construct(UpdateArticleOutput $output)
    {
        $this->output = $output;
    }

    /**
     * Web用ViewModelを返却
     * @return array
     */
    public function convertToWebView(): array
    {
        return [
            'isSuccess' => $this->output->isSuccess(),
            'message' => $this->output->message(),
        ];
    }
}
