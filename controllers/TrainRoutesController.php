<?php
namespace Rzd\Controllers;

require dirname(__DIR__) . '/vendor/autoload.php';

use OpenApi\Attributes as OA;

#[OA\Get(
    path: "/train_routes",
    summary: "Получение маршрутов поездов",
    description: "Возвращает маршруты поездов между двумя станциями."
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
    name: "dir",
    in: "query",
    required: false,
    description: "Направление (0 - в одну сторону, 1 - туда-обратно)",
    schema: new OA\Schema(type: "integer", default: 0)
)]
#[OA\Parameter(
    name: "tfl",
    in: "query",
    required: false,
    description: "Тип поезда (3 - поезда и электрички, 2 - электрички, 1 - поезда)",
    schema: new OA\Schema(type: "integer", default: 3)
)]
#[OA\Parameter(
    name: "checkSeats",
    in: "query",
    required: false,
    description: "Проверка наличия свободных мест (1 - с билетами, 0 - все поезда)",
    schema: new OA\Schema(type: "integer", default: 1)
)]
#[OA\Parameter(
    name: "dt0",
    in: "query",
    required: false,
    description: "Дата отправления в формате d.m.Y",
    schema: new OA\Schema(type: "string", format: "date", default: "")
)]
#[OA\Parameter(
    name: "md",
    in: "query",
    required: false,
    description: "Маршруты с пересадками (1 - с пересадками, 0 - только прямые рейсы)",
    schema: new OA\Schema(type: "integer", default: 0)
)]
#[OA\Response(
    response: 200,
    description: "Список маршрутов",
    content: new OA\JsonContent(
        type: "array",
        items: new OA\Items(ref: "#/components/schemas/TrainRoute")
    )
)]
#[OA\Response(
    response: 400,
    description: "Некорректные параметры запроса",
    content: new OA\JsonContent(
        properties: [
            new OA\Property(property: "error", type: "string", example: "Некорректный код станции отправления")
        ]
    )
)]
class TrainRoutesController
{
    public function trainRoutes()
    {
        $config = new \Rzd\Config();
        $config->setUserAgent('Mozilla 5');
        $config->setReferer('https://rzd.ru');
        $api = new \Rzd\Api($config);
        $tomorrow = new \DateTime('tomorrow');
        $params = [
            'code0' => $_GET['code0'],
            'code1' => $_GET['code1'],
            'dir' => $_GET['dir'] ?? 0,
            'tfl' => $_GET['tfl'] ?? 3,
            'checkSeats' => $_GET['checkSeats'] ?? 1,
            'dt0' => $_GET['dt0'] ?? $tomorrow->format('d.m.Y'),
            'md' => $_GET['md'] ?? 0,
        ];
        header('Content-type: application/json');
        echo $api->trainRoutes($params);
    }
}
?>