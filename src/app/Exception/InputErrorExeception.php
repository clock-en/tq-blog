<?php
namespace App\Exception;

use Exception;

final class InputErrorExeception extends Exception
{
    private $errors;

    public function setErrors(array $errors): self
    {
        $this->errors = $errors;
        return $this;
    }
    public function getErrors(): ?array
    {
        return $this->errors ?? null;
    }
}
