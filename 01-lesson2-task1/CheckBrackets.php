<?php

namespace otus\lesson02;


class CheckBrackets
{
    //Определяем список разрешённых символов входящих в строку
    private $symbols = ['(', ')', ' ', '\n', '\r', '\t'];

    public function verify(string $brackets)
    {
        // Преобразовываем строку в массив
        $bracketsArr = str_split($brackets);
        // Если в строке есть символы отличающиеся от списка допустимых
        if ((count(array_diff($bracketsArr, $this->symbols))) > 0) {
            // то выбрасываем соответствующее исключение
            throw new InvalidArgumentException('Строка содержит запрещённые символы!');
        } else {
            // проверяем правильность расстановки скобок и возвращаем результат
            return $this->check($brackets);
        }
    }

    private function check(string $brackets)
    {
        // Убираем из строки открывающиеся и закрывающиеся скобки пока они не закончатся
        $start = strlen($brackets);
        for ($boundary = floor(strlen($brackets) / 2), $i = 1; $i <= $boundary; $i++) {
            $brackets = str_replace('()', '', $brackets);
            if (strlen($brackets) == $start) exit;
        }
        //проверем оставшуюся строку на наличие незакрытых скобок
        return (strlen($brackets) > 0) ? false : true;
    }
}
/*
$CB = new CheckBrackets();
echo var_dump($CB->verify('()()'));
*/