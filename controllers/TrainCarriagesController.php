<?php
namespace Rzd\Controllers;

require dirname(__DIR__) . '/vendor/autoload.php';

use OpenApi\Attributes as OA;

#[OA\Get(
    path: "/train_carriages",
    summary: "Получение списка вагонов",
    description: "Возвращает список вагонов выбранного поезда."
)]
#[OA\Parameter(
    name: "code0",
    in: "query",
    required: true,
    description: "Код станции отправления",
    schema: new OA\Schema(type: "string")
)]
#[OA\Parameter(
    name: "code1",
    in: "query",
    required: true,
    description: "Код станции прибытия",
    schema: new OA\Schema(type: "string")
)]
#[OA\Parameter(
    name: "tnum0",
    in: "query",
    required: true,
    description: "Номер поезда",
    schema: new OA\Schema(type: "string")
)]
#[OA\Parameter(
    name: "time0",
    in: "query",
    required: true,
    description: "Время отправления",
    schema: new OA\Schema(type: "string", format: "time")
)]
#[OA\Parameter(
    name: "dt0",
    in: "query",
    required: false,
    description: "Дата отправления в формате d.m.Y",
    schema: new OA\Schema(type: "string", format: "date", default: "дата на завтра d.m.Y")
)]
#[OA\Parameter(
    name: "dir",
    in: "query",
    required: false,
    description: "Направление (0 - в одну сторону, 1 - туда-обратно)",
    schema: new OA\Schema(type: "integer", default: 0)
)]
#[OA\Response(
    response: 200,
    description: "Список вагонов",
    content: new OA\JsonContent(ref: "#/components/schemas/TrainCarriages")
)]
#[OA\Response(
    response: 400,
    description: "Некорректные параметры запроса",
    content: new OA\JsonContent(
        properties: [
            new OA\Property(property: "error", type: "string", example: "Некорректный номер поезда")
        ]
    )
)]
class TrainCarriagesController
{
    public function trainCarriages()
    {
        $config = new \Rzd\Config();
        $config->setUserAgent('Mozilla 5');
        $config->setReferer('https://rzd.ru');
        $api = new \Rzd\Api($config);
        $tomorrow = new \DateTime('tomorrow');
        $params = [
            'code0' => $_GET['code0'],
            'code1' => $_GET['code1'],
            'tnum0' => $_GET['tnum0'],
            'time0' => $_GET['time0'],
            'dt0' => $_GET['dt0'] ?? $tomorrow->format('d.m.Y'),
            'dir' => $_GET['dir'] ?? 0,
        ];
        header('Content-type: application/json');
        echo $api->trainCarriages($params);
    }
}
?>