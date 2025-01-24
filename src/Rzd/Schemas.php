<?php

namespace Rzd;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "TrainRoute",
    type: "object",
    required: ["route0", "route1", "date0", "time0", "number"],
    properties: [
        new OA\Property(property: "route0", type: "string", description: "Код станции отправления"),
        new OA\Property(property: "route1", type: "string", description: "Код станции прибытия"),
        new OA\Property(property: "date0", type: "string", format: "date", description: "Дата отправления"),
        new OA\Property(property: "time0", type: "string", format: "time", description: "Время отправления"),
        new OA\Property(property: "number", type: "string", description: "Номер поезда"),
        new OA\Property(property: "from", type: "string", description: "Название станции отправления"),
        new OA\Property(property: "where", type: "string", description: "Название станции прибытия"),
        new OA\Property(property: "date", type: "string", format: "date", description: "Дата отправления"),
        new OA\Property(property: "fromCode", type: "string", description: "Код станции отправления"),
        new OA\Property(property: "whereCode", type: "string", description: "Код станции прибытия"),
        new OA\Property(property: "time1", type: "string", format: "time", description: "Время прибытия"),
        new OA\Property(property: "timeInWay", type: "string", description: "Время в пути"),
        new OA\Property(property: "brand", type: "string", description: "Название поезда"),
        new OA\Property(property: "carrier", type: "string", description: "Тип поезда"),
        new OA\Property(property: "cars", type: "array", items: new OA\Items(ref: "#/components/schemas/Car"))
    ]
)]

#[OA\Schema(
    schema: "TrainCarriages",
    type: "object",
    required: ["cars"],
    properties: [
        new OA\Property(
            property: "cars",
            type: "array",
            items: new OA\Items(ref: "#/components/schemas/Carriage")
        )
    ]
)]

#[OA\Schema(
    schema: "Carriage",
    type: "object",
    required: ["cnumber", "type", "typeLoc", "clsType", "tariff", "seats"],
    properties: [
        new OA\Property(property: "cnumber", type: "string", description: "Номер вагона"),
        new OA\Property(property: "type", type: "string", description: "Тип вагона"),
        new OA\Property(property: "typeLoc", type: "string", description: "Полное наименование"),
        new OA\Property(property: "clsType", type: "string", description: "Класс обслуживания"),
        new OA\Property(property: "tariff", type: "number", format: "float", description: "Стоимость билета"),
        new OA\Property(
            property: "seats",
            type: "array",
            items: new OA\Items(ref: "#/components/schemas/Seat")
        )
    ]
)]

#[OA\Schema(
    schema: "Seat",
    type: "object",
    required: ["places", "tariff", "type", "free", "label"],
    properties: [
        new OA\Property(
            property: "places",
            type: "array",
            description: "Список свободных мест",
            items: new OA\Items(type: "string")
        ),
        new OA\Property(property: "tariff", type: "number", format: "float", description: "Цена за место"),
        new OA\Property(property: "type", type: "string", description: "Сокращенное наименование места"),
        new OA\Property(property: "free", type: "integer", description: "Количество свободных мест"),
        new OA\Property(property: "label", type: "string", description: "Полное наименование места")
    ]
)]

#[OA\Schema(
    schema: "Car",
    type: "object",
    properties: [
        new OA\Property(property: "freeSeats", type: "integer", description: "Количество свободных мест"),
        new OA\Property(property: "itype", type: "string", description: "Тип вагона"),
        new OA\Property(property: "servCls", type: "string", description: "Класс обслуживания (например, 2Ю, 2Ж)"),
        new OA\Property(property: "tariff", type: "number", format: "float", description: "Стоимость билета"),
        new OA\Property(property: "pt", type: "integer", description: "Баллы"),
        new OA\Property(property: "typeLoc", type: "string", description: "Полное наименование типа (Плацкартный, СВ, Купе, Люкс)"),
        new OA\Property(property: "type", type: "string", description: "Сокращенное наименование (Купе, плац, люкс)"),
        new OA\Property(property: "disabledPerson", type: "boolean", description: "Флаг обозначающий места для инвалидов")
    ]
)]

#[OA\Schema(
    schema: "TrainCarriage",
    type: "object",
    properties: [
        new OA\Property(property: "cars", type: "array", items: new OA\Items(ref: "#/components/schemas/Car")),
        new OA\Property(property: "functionBlocks", type: "array", items: new OA\Items(type: "object", description: "Блоки функций вагона")),
        new OA\Property(property: "schemes", type: "array", items: new OA\Items(type: "object", description: "Схемы вагонов")),
        new OA\Property(property: "companies", type: "array", items: new OA\Items(type: "object", description: "Компании страхователи"))
    ]
)]

#[OA\Schema(
    schema: "TrainInfo",
    type: "object",
    properties: [
        new OA\Property(property: "number", type: "string", description: "Номер поезда"),
        // Добавьте другие свойства, соответствующие данным пользователя
    ]
)]

#[OA\Schema(
    schema: "Route",
    type: "object",
    properties: [
        new OA\Property(property: "station", type: "string", description: "Название станции"),
        new OA\Property(property: "arrival_time", type: "string", format: "time", description: "Время прибытия"),
        new OA\Property(property: "departure_time", type: "string", format: "time", description: "Время отправления"),
        // Добавьте другие свойства, соответствующие маршруту
    ]
)]

#[OA\Schema(
    schema: "StationCode",
    type: "object",
    properties: [
        new OA\Property(property: "station", type: "string", description: "Название станции"),
        new OA\Property(property: "code", type: "string", description: "Код станции"),
    ]
)]
class Schemas
{
    // Этот класс служит только для определения схем OpenAPI
}
?>