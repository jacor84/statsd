<?php

use Domnikl\Statsd\Client as StatsDClient;
use Domnikl\Statsd\Connection\UdpSocket;

require_once __DIR__ . "/vendor/autoload.php";

$statsDHost = $argv[1] ?? getenv("STATSD_HOST") ?: "localhost";
$statsDPort = $argv[2] ?? getenv("STATSD_PORT") ?: 8125;

$connection = new UdpSocket($statsDHost, $statsDPort);
$statsd = new StatsDClient($connection, "centra");

printf("Sending stats via UDP socket to $statsDHost:$statsDPort...");
$value = 100;

while (true) {
    printf(".");
    try {
        if (random_int(0, 100) > 90) {
            throw new UnexpectedValueException("What???");
        }

        $statsd->startMemoryProfile("memory");
        $statsd->startTiming("home-page");
        strrev(file_get_contents("https://www.centra.com/"));
        $statsd->endTiming("home-page");
        $statsd->endMemoryProfile("memory");

        $statsd->increment("ticks");

        $statsd->gauge("gauge", random_int(0, 100));

        $value += random_int(-20, 20);
        if ($value < 0) {
            $value += 20;
        }
        $statsd->count("random-walk", $value);
    } catch (Throwable $e) {
        $statsd->increment("exception." . get_class($e));
    }
    usleep(random_int(1000, 100000));
}
