<?php

namespace App\Livewire\Powergrid;

use App\Models\Cliente;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use PowerComponents\LivewirePowerGrid\{Button, Column, PowerGridFields, PowerGridComponent};
use PowerComponents\LivewirePowerGrid\Facades\{Filter, Rule, PowerGrid};

final class ClienteTable extends PowerGridComponent
{
    public string $tableName = 'cliente-table';

    protected $listeners = [
        'reloadPowergrid',
    ];

    public function reloadPowergrid()
    {
        $this->refresh();
    }

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

    public function header(): array
    {
        return [
            Button::add('cadastrar-cliente')
                ->slot('Cadastrar Cliente')
                ->class('btn btn-primary mt-2')
                ->openModal('modal.cliente', []),
        ];
    }

    public function datasource(): Builder
    {
        return Cliente::query();
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('nome')
            ->add('cnpj')
            ->add('contato')
            ->add('email')
            ->add('ativo')
            ->add('endereco')
            ->add('observacao')
            ->add('ativo')
            ->add('created_at_formatted', fn (Cliente $model) => Carbon::parse($model->created_at)->format('d/m/Y'));
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->searchable()
                ->sortable(),
            Column::make('Nome', 'nome')
                ->searchable()
                ->sortable(),
            Column::make('CNPJ', 'cnpj')
                ->searchable()
                ->sortable(),
            Column::make('Contato', 'contato')
                ->searchable()
                ->sortable(),
            Column::make('E-mail', 'email')
                ->searchable()
                ->sortable(),
            Column::make('Endereço', 'endereco')
                ->searchable()
                ->sortable(),
            Column::make('Observação', 'observacao')
                ->searchable()
                ->sortable(),
            Column::make('Ativo?', 'ativo')
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
            Filter::inputText('nome'),
            Filter::inputText('cnpj'),
            Filter::inputText('contato'),
            Filter::inputText('email'),
            Filter::datepicker('created_at_formatted', 'created_at'),
        ];
    }

    #[\Livewire\Attributes\On('edit')]
    public function edit($rowId): void
    {
        $this->js('alert('.$rowId.')');
    }

    public function actions(Cliente $row): array
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
    public function actionRules(Cliente $row): array
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
