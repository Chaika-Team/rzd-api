<?php
require __DIR__ . '/../bootstrap.php';

$api = new Rzd\Api();

$start = new DateTime();
$date0 = $start->modify('+1 day');

$params = [
    'train_num' => '072Е',
    'date'      => $date0->format('d.m.Y'),
];

echo json_encode($api->trainStationList($params));
