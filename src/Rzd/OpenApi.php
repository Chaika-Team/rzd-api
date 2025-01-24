<?php

namespace Rzd;

use OpenApi\Attributes as OA;

#[OA\Info(
    title: "RZD API",
    version: "1.0.0",
    description: "API для получения информации о маршрутах поездов, вагонах и станциях.",
)]
#[OA\Server(
    url: "https://api.rzd.ru",
    description: "Cервер РЖД"
)]
#[OA\Tag(
    name: "Train Routes",
    description: "Операции связанные с маршрутами поездов"
)]
#[OA\Tag(
    name: "Train Carriages",
    description: "Операции связанные с вагонами поездов"
)]
#[OA\Tag(
    name: "Train Station",
    description: "Операции связанные со станциями поездов"
)]
class OpenApi
{
    // Этот класс служит только для аннотаций OpenAPI
}
?>