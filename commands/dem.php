<?php
    /**
     * @link 
     */
    declare(ticks = 1);
 
    $stop = FALSE;
 
    /**
     * Функция перехватывающая сигналы
     */
    function sig_handler($signo)
    {
        global $stop;
        switch ($signo) 
        {
            case SIGTERM:
                echo "Закрываем какие-нибудь соединения с базой\n";
                echo "Для примера, ждём 5 секунд, и устанавливаем флаг завершения работы\n";
                sleep(5);
                $stop = TRUE;
                echo "Время прошло\n";
                break;
            case SIGUSR1:
                echo "Привет, ты вызвал пользовательский сигнал\n";
                break;
            default:
                // Ловим все остальные сигналы
        }
    }
 
    // Регистрируем сигналы
    pcntl_signal(SIGTERM, "sig_handler");
    pcntl_signal(SIGUSR1, "sig_handler");
 
 
    // Форкаем процесс
    $pid = pcntl_fork();
 
    if ($pid == -1) 
    {
	    // Ошибка 
	    die('could not fork'.PHP_EOL);
    } 
    else if ($pid) 
    {
	    // Родительский процесс, убиваем
	    die('die parent process'.PHP_EOL);
    } 
    else 
    {
	    // Новый процесс, запускаем главный цикл
	    while( ! $stop ) 
	    {
            // Тут выполняется какая-то важная работа
	    }
    }
    // Отцепляемся от терминала
    posix_setsid();