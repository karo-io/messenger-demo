<?php

use KaroIO\MessengerMonitor\KaroIOMessengerMonitorBundle;

return [
    Symfony\Bundle\FrameworkBundle\FrameworkBundle::class => ['all' => true],
    Doctrine\Bundle\DoctrineBundle\DoctrineBundle::class => ['all' => true],
    Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle::class => ['all' => true],
    KaroIOMessengerMonitorBundle::class => ['all' => true],
];
