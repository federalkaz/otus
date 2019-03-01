<?php
#!/usr/local/bin/php -q

include_once '..\01-lesson2-task1\CheckBrackets.php';
$checkBrackets = new CheckBrackets();

error_reporting(E_ALL);

/* Позволяет скрипту ожидать соединения бесконечно. */
set_time_limit(0);

/* Включает скрытое очищение вывода так, что мы видим данные
 * как только они появляются. */
ob_implicit_flush();

$port = getopt('p:');

$address = '127.0.0.1';
$port = $port['p'];

if (($sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) === false) {
    echo "Failed to execute socket_create(): cause: " . socket_strerror(socket_last_error()) . "\n";
}

if (socket_bind($sock, $address, $port) === false) {
    echo "Failed to execute socket_bind(): cause: " . socket_strerror(socket_last_error($sock)) . "\n";
}

socket_set_option($sock, SOL_SOCKET, SO_REUSEADDR, 1);

if (socket_listen($sock, 5) === false) {
    echo "Failed to execute socket_listen(): cause: " . socket_strerror(socket_last_error($sock)) . "\n";
}

do {
    if (($msgsock = socket_accept($sock)) === false) {
        echo "Failed to execute socket_accept(): cause: " . socket_strerror(socket_last_error($sock)) . "\n";
        break;
    }
    /* Отправляем инструкции. */
    $msg = "\nWelcome to test server PHP. \n" .
        "To disconnect, type 'exit'. To shut down the server, type 'shutdown'.\n";
    socket_write($msgsock, $msg, strlen($msg));

    do {
        if (false === ($buf = socket_read($msgsock, 2048, PHP_NORMAL_READ))) {
            echo "Failed to execute socket_read(): cause: " . socket_strerror(socket_last_error($msgsock)) . "\n";
            break 2;
        }
        if (!$buf = trim($buf)) {
            continue;
        }
        if ($buf == 'exit') {
            break;
        }
        if ($buf == 'shutdown') {
            socket_close($msgsock);
            break 2;
        }
        /*
        $talkback = "PHP: You say '$buf'.\n";
        socket_write($msgsock, $talkback, strlen($talkback));
        echo "$buf\n";
        */
        if ($checkBrackets->verify($buf)) {
            $talkback = 'The brackets are arranged correctly!';
        } else {
            $talkback = 'The brackets are wrong!';
        }
        socket_write($msgsock, $talkback, strlen($talkback));

    } while (true);
    socket_close($msgsock);
} while (true);

socket_close($sock);
