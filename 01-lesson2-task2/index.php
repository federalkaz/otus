#!/usr/bin/php
<?php

namespace otus\lesson02;

include_once '..\01-lesson2-task1\CheckBrackets.php';

$checkBrackets = new CheckBrackets();


$path = readline('Введите адрес до файла со строкой: ');
// Считать строку
$text = file_get_contents($path) or die("Невозможно открыть файл: $php_errormsg");
// Передать строку библиотеке
echo 'Считанный текст -> '.$text.PHP_EOL;
// Вернуть результат в терминал
if ($checkBrackets->verify($text)) {
    echo 'Скобки расставлены правильно!';
} else {
    echo 'Скобки расставлены неправильно!';
}

