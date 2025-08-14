<?php

namespace App\Livewire\Powergrid;

use App\Models\Equipamento;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use PowerComponents\LivewirePowerGrid\{Button, Column, PowerGridFields, PowerGridComponent};
use PowerComponents\LivewirePowerGrid\Facades\{Filter, Rule, PowerGrid};

final class EquipamentoTable extends PowerGridComponent
{
    public string $tableName = 'equipamento-table';

    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            PowerGrid::header()
                ->showSearchInput(),
            PowerGrid::footer()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        return Equipamento::query();
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('cliente_id')
            ->add('tipo')
            ->add('marca')
            ->add('modelo')
            ->add('serial')
            ->add('ativo')
            ->add('contador')
            ->add('tipo_posse')
            ->add('observacao')
            ->add('created_at_formatted', fn (Equipamento $model) => Carbon::parse($model->created_at)->format('d/m/Y'));
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->searchable()
                ->sortable(),
            Column::make('ID Cliente', 'cliente_id')
                ->searchable()
                ->sortable(),
            Column::make('Tipo', 'tipo')
                ->searchable()
                ->sortable(),
            Column::make('Marca', 'marca')
                ->searchable()
                ->sortable(),
            Column::make('Modelo', 'modelo')
                ->searchable()
                ->sortable(),
            Column::make('Serial', 'serial')
                ->searchable()
                ->sortable(),
            Column::make('Contador', 'contador')
                ->searchable()
                ->sortable(),
            Column::make('Tipo Posse', 'tipo_posse')
                ->searchable()
                ->sortable(),
            Column::make('Observação', 'observacao')
                ->searchable()
                ->sortable(),
            Column::make('Criado Em', 'created_at_formatted', 'created_at')
                ->searchable(),
            Column::action('Ação')
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('cliente_id'),
            Filter::inputText('tipo'),
            Filter::inputText('marca'),
            Filter::inputText('modelo'),
            Filter::inputText('serial'),
            Filter::inputText('contador'),
            Filter::inputText('tipo_posse'),
            Filter::datepicker('created_at_formatted', 'created_at'),
        ];
    }

    #[\Livewire\Attributes\On('edit')]
    public function edit($rowId): void
    {
        $this->js('alert('.$rowId.')');
    }

    public function actions(Equipamento $row): array
    {
        return [
            Button::add('editar-cliente')
                ->slot('Edit: '.$row->id)
                ->id()
                ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
                ->dispatch('edit', ['rowId' => $row->id])
        ];
    }

    /*
    public function actionRules(Equipamento $row): array
    {
       return [
            // Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($row) => $row->id === 1)
                ->hide(),
        ];
    }
    */
}
