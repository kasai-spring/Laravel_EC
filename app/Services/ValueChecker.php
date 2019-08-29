<?php

namespace App\Services;
//filter定義
define("USERNAME", 0);
define("PASSWORD", 1);
define("EMAIL", 2);

class ValueChecker
{

    public function validationChecker(string $target, string $form_name, $filter)
    {
        //文頭のスペース削除
        $target = preg_replace("/\A[ 　\t]+/", "", $target);
        $result = array();
        switch ($filter) {
            case USERNAME:
                $result = $this->wordCounter($target, $form_name, 1, 16, $result);
                $result = $this->charChecker($target, $form_name, "/[^0-9a-zA-Z_-]/", $result);
                break;
            case PASSWORD:
                $result = $this->wordCounter($target, $form_name, 1, 32, $result);
                $result = $this->charChecker($target, $form_name, "/[^0-9a-zA-Z_-]/", $result);
                break;
            case EMAIL:
                $result = $this->wordCounter($target, $form_name, 3, 256, $result);
                if (!(bool)filter_var($target, FILTER_VALIDATE_EMAIL)) {
                    $result[] = "メールアドレスが不適切です";
                }
                break;
        }
        if (count($result) === 0) {
            return array(true, $target);
        } else {
            array_unshift($result, false);
            return $result;
        }
    }

    private function wordCounter(string $target, string $form_name, int $min_len, int $max_len, array $result)
    {
        if (iconv_strlen($target) <= $min_len || iconv_strlen($target) >= $max_len) {
            $result[] = $form_name . "は" . $min_len . "文字以上" . $max_len . "文字以下で入力してください";
        }
        return $result;
    }

    private function charChecker(string $target, string $form_name, string $regex, array $result)
    {
        if (preg_match($regex, $target) === 1) {
            $result[] = $form_name . "に使用できない文字が含まれています";
        }
        return $result;
    }

}

