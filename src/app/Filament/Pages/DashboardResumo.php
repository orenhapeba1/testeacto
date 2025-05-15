<?php
namespace App\Filament\Pages;

use App\Models\Form;
use App\Models\Question;
use App\Models\Answer;
use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;

class DashboardResumo extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?string $navigationLabel = 'Dashboard Resumo';
    protected static string $view = 'filament.pages.dashboard-resumo';

    public int $totalForms = 0;
    public int $totalFormsRespondidos = 0;
    public int $totalQuestions = 0;

    public function mount(): void
    {
        $this->totalForms = Form::count();
        $this->totalFormsRespondidos = Form::where('locked', true)->count();
        $this->totalQuestions = Question::count();
        
    }

    protected function getViewData(): array
    {
        return [
            'totalForms' => $this->totalForms,
            'totalFormsRespondidos' => $this->totalFormsRespondidos,
            'totalQuestions' => $this->totalQuestions
        ];
    }
}
