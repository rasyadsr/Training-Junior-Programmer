<?php

$data = <<<'EOD'

X, -9\\\10\100\-5\\\0\\\\, A

Y, \\13\\1\, B

Z, \\\5\\\-3\\2\\\800, C

EOD;

function filterAndSortNumber(array $data): array
{
    $numberOnly = array_filter($data, 'is_numeric');
    sort($numberOnly);
    return $numberOnly;
}

function findFirstCharAndLastChar(array $array, int $target): array
{
    // cari dulu target nya ada di index ke berapa
    $indexTarget = array_search($target, $array);

    // find firstChar
    $firstChar = "";

    for ($i = $indexTarget - 1; $i >= 0; $i--) {
        if (!is_numeric($array[$i])) {
            $firstChar = $array[$i];
            break;
        }
    }

    // find lastChar
    $lastChar = "";
    for ($i = $indexTarget + 1; $i < count($array); $i++) {
        if (!is_numeric($array[$i])) {
            $lastChar = $array[$i];
            break;
        }
    }

    $firstCharIndex = array_search($firstChar, $array);
    $lastCharIndex = array_search($lastChar, $array);

    // grouping array berdasarkan firstChar dan lastChar
    $arrNotSortedThisTarget = array_splice(
        $array,
        $firstCharIndex,
        ($lastCharIndex + 1) - $firstCharIndex
    );

    $sortedArrayThisTarget = [
        $firstChar,
        ...filterAndSortNumber($arrNotSortedThisTarget),
        $lastChar
    ];

    // Cari index dari si target nya yang udah di sorting
    $indexTargetThisArray = array_search($target, $sortedArrayThisTarget);

    return [$firstChar, $lastChar, $indexTargetThisArray];
}

function createPattern(string $text): void
{
    $arrayOfContent = preg_split("/[\\\s\s+,]+/", trim($text));

    foreach (filterAndSortNumber($arrayOfContent) as $value) {
        [$firstChar, $lastChar, $indexTargetChar] = findFirstCharAndLastChar($arrayOfContent, $value);
        echo "$firstChar,$value,$lastChar,$indexTargetChar" . PHP_EOL;
    }
}

createPattern($data);
