<x-filament::page>
    <div class="grid grid-cols-3 md:grid-cols-3 gap-4 mb-8">
        <div class="bg-white rounded-lg shadow p-4">
            <h4 class="text-sm font-medium text-gray-500">Formulários Criados</h4>
            <p class="text-2xl font-bold text-gray-900 dark:text-primary-400">{{ $totalForms }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <h4 class="text-sm font-medium text-gray-500">Formulários Respondidos</h4>
            <p class="text-2xl font-bold text-gray-900 dark:text-primary-400">{{ $totalFormsRespondidos }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <h4 class="text-sm font-medium text-gray-500">Perguntas Criadas</h4>
            <p class="text-2xl font-bold text-gray-900 dark:text-primary-400">{{ $totalQuestions }}</p>
        </div>
        
    </div>

</x-filament::page>