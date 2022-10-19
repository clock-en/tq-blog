<?php
namespace App\Adapter\ViewModel;

use App\UseCase\SignUp\SignUpOutput;

final class SignUpViewModel
{
    private SignUpOutput $output;

    public function __construct(SignUpOutput $output)
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
