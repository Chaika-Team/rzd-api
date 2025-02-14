// internal/service/interface.go
package service

import (
	"context"

	"github.com/Chaika-Team/rzd-api/internal/domain"
)

// Service интерфейс сервиса для работы с маршрутами поездов и вагонами поездов РЖД
type Service interface {
	// GetTrainRoutes возвращает маршруты поездов
	GetTrainRoutes(ctx context.Context, params domain.GetTrainRoutesParams) ([]domain.TrainRoute, error)
	// GetTrainCarriages возвращает информацию о вагонах поезда
	GetTrainCarriages(ctx context.Context, params domain.GetTrainCarriagesParams) ([]domain.Car, error)
	// SearchStation возвращает коды станций основываясь на поисковом запросе
	SearchStation(ctx context.Context, params domain.SearchStationParams) ([]domain.Station, error)
	// GetTrainRoutesReturn возвращает маршруты туда и обратно
	//GetTrainRoutesReturn(ctx context.Context, params domain.GetTrainRoutesReturnParams) ([]domain.TrainRoute, []domain.TrainRoute, error)
	// GetTrainStationList возвращает список станций поезда по его номеру
	//GetTrainStationList(ctx context.Context, params domain.GetTrainStationListParams) (domain.TrainStationListResponse, error)
}
