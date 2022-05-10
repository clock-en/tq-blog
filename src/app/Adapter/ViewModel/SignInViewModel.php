<?php
namespace App\Adapter\ViewModel;

use App\UseCase\SignIn\SignInOutput;

final class SignInViewModel
{
    private SignInOutput $output;

    public function __construct(SignInOutput $output)
    {
        $this->output = $output;
    }

    public function convertToWebView(): array
    {
        return [
            'isSuccess' => $this->output->isSuccess(),
            'message' => $this->output->message(),
        ];
    }
}
