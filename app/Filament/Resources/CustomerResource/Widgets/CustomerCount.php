<?php

namespace App\Filament\Resources\CustomerResource\Widgets;

use App\Models\Customer;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class CustomerCount extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Total Customers', $this->query())
                ->description('All customers in the system')
                ->descriptionIcon('heroicon-o-users'),
        ];
    }

    protected function query()
    {
        return Customer::count();
    }
}
