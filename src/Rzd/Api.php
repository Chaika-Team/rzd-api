<?php

namespace Rzd;

use GuzzleHttp\Exception\GuzzleException;
use JsonException;
use OpenApi\Attributes as OA;

#[OA\Tag(
     name: "RZD API",
     description: "API для взаимодействия с сайтом rzd.ru"
)]
class Api
{
     public const ROUTES_LAYER = 5827;
     public const CARRIAGES_LAYER = 5764;
     public const STATIONS_STRUCTURE_ID = 704;

     /**
      * Путь получения маршрутов
      *
      * @var string
      */
     protected string $path = 'https://pass.rzd.ru/timetable/public/';

     /**
      * Путь получения кодов станций
      *
      * @var string
      */
     protected string $suggestionPath = 'https://pass.rzd.ru/suggester';

     /**
      * Путь получения станций маршрута
      *
      * @var string
      */
     protected string $stationListPath = 'https://pass.rzd.ru/ticket/services/route/basicRoute';

     private Query $query;
     private string $lang;

     /**
      * Api constructor.
      *
      * @param Config|null $config
      */
     public function __construct(Config $config = null)
     {
          if (!$config) {
               $config = new Config();
          }

          $this->lang = $config->getLanguage();
          $this->path .= $this->lang;
          $this->query = new Query($config);
     }

     /**
      * Получает маршруты в 1 точку
      *
      * @param array $params Массив параметров
      *
      * @return string
      * @throws GuzzleException|JsonException
      */
     #[OA\Get(
          path: "/api/trainRoutes",
          tags: ["RZD API"],
          summary: "Получение маршрутов в одну точку",
          description: "Возвращает маршруты поездов из одной точки в другую."
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
     public function trainRoutes(array $params): string
     {
          $layer = [
               'layer_id' => static::ROUTES_LAYER,
          ];
          $routes = $this->query->get($this->path, $layer + $params);

          return json_encode($routes->tp[0]->list, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);
     }

     /**
      * Получает маршруты туда-обратно
      *
      * @param array $params Массив параметров
      *
      * @return string
      * @throws GuzzleException|JsonException
      */
     #[OA\Get(
          path: "/api/trainRoutesReturn",
          tags: ["RZD API"],
          summary: "Получение маршрутов туда-обратно",
          description: "Возвращает маршруты поездов туда и обратно между двумя точками."
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
          schema: new OA\Schema(type: "integer", default: 1)
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
          name: "dt1",
          in: "query",
          required: false,
          description: "Дата возврата в формате d.m.Y",
          schema: new OA\Schema(type: "string", format: "date", default: "")
     )]
     #[OA\Response(
          response: 200,
          description: "Список маршрутов туда и обратно",
          content: new OA\JsonContent(
               properties: [
                    new OA\Property(property: "forward", type: "array", items: new OA\Items(ref: "#/components/schemas/TrainRoute")),
                    new OA\Property(property: "back", type: "array", items: new OA\Items(ref: "#/components/schemas/TrainRoute"))
               ]
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
     public function trainRoutesReturn(array $params): string
     {
          $layer = [
               'layer_id' => static::ROUTES_LAYER,
          ];
          $routes = $this->query->get($this->path, $layer + $params);

          return json_encode(
               [
                    'forward' => $routes->tp[0]->list,
                    'back' => $routes->tp[1]->list,
               ],
               JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE
          );
     }

     /**
      * Получение списка вагонов
      *
      * @param array $params Массив параметров
      *
      * @return string
      * @throws GuzzleException|JsonException
      */
     #[OA\Get(
          path: "/api/trainCarriages",
          tags: ["RZD API"],
          summary: "Получение списка вагонов",
          description: "Возвращает список вагонов выбранного поезда с информацией о свободных местах и тарифах."
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
          schema: new OA\Schema(type: "string", format: "date", default: "")
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
     public function trainCarriages(array $params): string
     {
          $layer = [
               'layer_id' => static::CARRIAGES_LAYER,
          ];
          $carriages = $this->query->get($this->path, $layer + $params);

          return json_encode(
               [
                    'cars' => $carriages->lst[0]->cars ?? null,
                    'functionBlocks' => $carriages->lst[0]->functionBlocks ?? null,
                    'schemes' => $carriages->schemes ?? null,
                    'companies' => $carriages->insuranceCompany ?? null,
               ],
               JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE
          );
     }

     /**
      * Получение списка станций
      *
      * @param array $params Массив параметров
      *
      * @return string
      * @throws GuzzleException|JsonException
      */
     #[OA\Get(
          path: "/api/trainStationList",
          tags: ["RZD API"],
          summary: "Получение списка станций",
          description: "Возвращает список всех станций в текущем маршруте движения поезда."
     )]
     #[OA\Parameter(
          name: "trainNumber",
          in: "query",
          required: true,
          description: "Номер поезда",
          schema: new OA\Schema(type: "string")
     )]
     #[OA\Parameter(
          name: "depDate",
          in: "query",
          required: true,
          description: "Дата отправления в формате d.m.Y",
          schema: new OA\Schema(type: "string", format: "date")
     )]
     #[OA\Response(
          response: 200,
          description: "Список станций",
          content: new OA\JsonContent(
               properties: [
                    new OA\Property(property: "train", ref: "#/components/schemas/TrainInfo"),
                    new OA\Property(property: "routes", type: "array", items: new OA\Items(ref: "#/components/schemas/Route"))
               ]
          )
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
     public function trainStationList(array $params): string
     {
          $layer = [
               'STRUCTURE_ID' => static::STATIONS_STRUCTURE_ID,
          ];
          $stations = $this->query->get($this->stationListPath, $layer + $params);

          return json_encode(
               [
                    'train' => $stations->data->trainInfo,
                    'routes' => $stations->data->routes,
               ],
               JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE
          );
     }

     /**
      * Получение списка кодов станций
      *
      * @param array $params Массив параметров
      *
      * @return string
      * @throws GuzzleException|JsonException
      */
     #[OA\Get(
          path: "/api/stationCode",
          tags: ["RZD API"],
          summary: "Получение списка кодов станций",
          description: "Возвращает список кодов станций на основе части названия станции."
     )]
     #[OA\Parameter(
          name: "stationNamePart",
          in: "query",
          required: true,
          description: "Часть названия станции (минимум 2 символа)",
          schema: new OA\Schema(type: "string")
     )]
     #[OA\Parameter(
          name: "compactMode",
          in: "query",
          required: false,
          description: "Режим компактного отображения (y - да)",
          schema: new OA\Schema(type: "string", default: "y")
     )]
     #[OA\Response(
          response: 200,
          description: "Список кодов станций",
          content: new OA\JsonContent(
               type: "array",
               items: new OA\Items(ref: "#/components/schemas/StationCode")
          )
     )]
     #[OA\Response(
          response: 400,
          description: "Некорректные параметры запроса",
          content: new OA\JsonContent(
               properties: [
                    new OA\Property(property: "error", type: "string", example: "Необходим минимум 2 символа для поиска")
               ]
          )
     )]
     public function stationCode(array $params): string
     {
          $lang = [
               'lang' => $this->lang,
          ];

          $routes = $this->query->get($this->suggestionPath, $lang + $params, 'GET');
          $stations = [];

          if ($routes) {
               foreach ($routes as $station) {
                    if (mb_stristr($station->n, $params['stationNamePart'])) {
                         $stations[] = [
                              'station' => $station->n,
                              'code' => $station->c,
                         ];
                    }
               }
          }

          return json_encode($stations, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);
     }
}
?>