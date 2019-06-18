<?php

/** @var boolean $shallStopWorking флаг остановки */
$shallStopWorking = false;

/** @var Closure $onSigterm */
$onSigterm = function () use (&$shallStopWorking) {
    echo "Received SIGTERM\n";
    $shallStopWorking = true;
};

// сигнал об остановке от supervisord
pcntl_signal(SIGTERM, $onSigterm);

/** @var Closure $onSigint */
$onSigint = function () use (&$shallStopWorking) {
    echo "Received SIGINT\n";
    $shallStopWorking = true;
};

// обработчик для ctrl+c
pcntl_signal(SIGINT, $onSigint);

echo "Started\n";

while (!$shallStopWorking) {

    // обрабатываем задания из очереди, считаем статистику чего-либо,
    // или делаем ещё что-то очень важное

    // или совершенно бесполезное
    for ($i = 0; $i < 10; $i += 1) sleep(1);
    echo "Slept for ten seconds\n";

    // обработаем сигналы в конце итерации
    pcntl_signal_dispatch();
}

echo "Finished\n";