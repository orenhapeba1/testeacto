<?php

namespace App\Filament\Widgets;

use App\Models\Form;
use App\Models\Question;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Formularios Criados',  Form::count()),
            Stat::make('Formularios Respondidos', Form::where('locked', true)->count()),
            Stat::make('Perguntas Criadas', Question::count()),
        ];
    }
}
