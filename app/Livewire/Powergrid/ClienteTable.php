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
            ->add('cnpj', fn(Cliente $c) => 
                strlen($c->cnpj ?? '') === 14
                    ? substr($c->cnpj, 0, 2) . '.' .
                    substr($c->cnpj, 2, 3) . '.' .
                    substr($c->cnpj, 5, 3) . '/' .
                    substr($c->cnpj, 8, 4) . '-' .
                    substr($c->cnpj, 12, 2)
                    : ($c->cnpj ?? '')
            )
            ->add('contato', fn(Cliente $c) =>
                strlen($c->contato ?? '') === 11
                    ? '(' . substr($c->contato, 0, 2) . ') ' .
                    substr($c->contato, 2, 5) . '-' .
                    substr($c->contato, 7, 4)
                    : ($c->contato ?? '')
            )
            ->add('email')
            ->add('endereco')
            ->add('observacao')
            ->add('ativo')
            ->add('created_at_formatted', fn (Cliente $model) => 
                Carbon::parse($model->created_at)->format('d/m/Y')
            );
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
                ->toggleable(
                    true,
                    'Sim',
                    'Não'
                )
                ->searchable()
                ->sortable(),

            Column::make('Criado Em', 'created_at_formatted', 'created_at')
                ->searchable(),
            Column::action('Ação')
        ];
    }

    public function onUpdatedToggleable(string|int $id, string $field, string $value): void
    {
        Cliente::query()
            ->find($id)
            ->update([$field => $value]);

        $this->dispatch('reloadPowergrid');
    }

    public function filters(): array
    {
        return [
            Filter::inputText('nome'),
            Filter::inputText('cnpj'),
            Filter::inputText('contato'),
            Filter::inputText('email'),
            Filter::datepicker('created_at_formatted', 'created_at'),
            Filter::boolean('ativo', 'ativo')->label('Sim', 'Não'),
        ];
    }

    public function actions(Cliente $cliente): array
    {
        return [
            Button::add('editar-cliente')
                ->slot('<i class="fa fa-lg fa-fw fa-pen"></i>')
                ->class('btn btn-xs text-primary')
                ->openModal('modal.cliente', [
                    'id' => $cliente->id,
                ])
            ,
            Button::add('deletar-cliente')
                ->slot('<i class="fa fa-lg fa-fw fa-trash"></i>')
                ->class('btn btn-xs text-primary')
                ->dispatch('delete', ['cliente' => $cliente])
            ,
        ];
    }

    #[\Livewire\Attributes\On('delete')]
    public function delete($cliente): void
    {
        $id = $cliente['id'];
        $this->js("alertaDelete($id, 'Deseja excluir <b>{$cliente['nome']}</b>?', 'deleteRow')");
    }

    #[\Livewire\Attributes\On('deleteRow')]
    public function deleteRow($id): void
    {
        $cliente = Cliente::find($id);
        $result = $cliente->delete();

        if ($result) {
            $this->js("alertaSucesso('<b>$cliente->nome</b> excluído com sucesso')");
        } else {
            $this->js("alertaFalha('Erro ao excluir <b>Cliente</b>')");
        }
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
