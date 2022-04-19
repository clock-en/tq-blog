<?php
namespace App\Infrastructure\Dao;

final class FormDataSessionDao
{
    const SESSION_NAME = 'formData';

    private $formData;

    public function __construct()
    {
        $this->formData = $_SESSION[self::SESSION_NAME] ?? [];
        unset($_SESSION[self::SESSION_NAME]);
    }

    /**
     * フォーム入力値の取得
     * @return array | null
     */
    public function getFormData(): ?array
    {
        if (!empty($this->formData)) {
            return $this->formData;
        }
        return null;
    }

    /**
     * フォーム入力値の設定
     * @param array $formData
     */
    public function setFormData(array $formData): void
    {
        $this->formData = $formData;
        $_SESSION[self::SESSION_NAME] = $formData;
    }
}
