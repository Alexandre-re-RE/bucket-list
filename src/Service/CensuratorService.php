<?php

namespace App\Service;

class CensuratorService {

    const NWORD_LIST = [
        "moukate",
        "mort",
        "sucide",
        "seins",
    ];

    /**
     * purify shit text function
     *
     * @param string $textToPurify
     * @return string
     */
    public function purify(string $textToPurify): string
    {
        foreach(self::NWORD_LIST as $word) {
            $textToPurify = str_replace($word, "***", $textToPurify);
        }
        return $textToPurify;
    }
}