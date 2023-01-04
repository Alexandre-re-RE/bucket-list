<?php

namespace App\Service;

class CensuratorService {

    const NWORD_LIST = [
        "moukate",
        "mort",
        "sucide",
        "seins",
    ];

    public function purify(string $textToPurify)
    {
        foreach(self::NWORD_LIST as $word) {
            $textToPurify = str_replace($word, "***", $textToPurify);
        }
        return $textToPurify;
    }
}