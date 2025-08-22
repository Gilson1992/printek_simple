<?php

namespace App\Livewire\Powergrid;

use App\Helpers\PowerGridThemes\TailwindHeaderFixed;
use App\Models\Servico;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use PowerComponents\LivewirePowerGrid\{Button, Column, PowerGridFields, PowerGridComponent};
use PowerComponents\LivewirePowerGrid\Facades\{Filter, Rule, PowerGrid};

final class ServicoTable extends PowerGridComponent
{
    public string $tableName = 'servico-table';

    protected $listeners = [
        'reloadPowergrid',
    ];

    public function customThemeClass(): ?string
    {
        return TailwindHeaderFixed::class;
    }

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
            Button::add('cadastrar-servico')
                ->slot('Cadastrar Serviço')
                ->class('btn btn-primary mt-2 mr-2 text-bold')
                ->openModal('modal.servico', []),
        ];
    }

    public function datasource(): Builder
    {
        return Servico::query();
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('descricao')
            ->add('codigo')
            ->add('contador')
            ->add('preco_formatado', fn (Servico $model) =>
                'R$ ' . number_format($model->preco, 2, ',', '.')
            )
            ->add('created_at_formatado', fn (Servico $model) => Carbon::parse($model->created_at)->format('d/m/Y'));
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->searchable()
                ->sortable(),
            Column::make('Descrição', 'descricao')
                ->searchable()
                ->sortable(),
            Column::make('Código', 'codigo')
                ->searchable()
                ->sortable(),
            Column::make('Contador', 'contador')
                ->searchable()
                ->sortable(),
            Column::make('Preço', 'preco_formatado')
                ->searchable()
                ->sortable(),
            Column::make('Criado Em', 'created_at_formatado', 'created_at')
                ->searchable(),
            Column::action('Ação')
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('descricao')->operators([]),
            Filter::inputText('nome')->operators([]),
            Filter::inputText('contato')->operators([]),
            Filter::inputText('preco')->operators([]),
            Filter::datepicker('created_at_formatado', 'created_at'),
        ];
    }

    public function actions(Servico $servico): array
    {
        return [
            Button::add('editar-servico')
                ->slot('<i class="fa fa-lg fa-fw fa-pen"></i>')
                ->class('btn btn-xs text-primary')
                ->openModal('modal.servico', [
                    'id' => $servico->id,
                ])
            ,
            Button::add('deletar-servico')
                ->slot('<i class="fa fa-lg fa-fw fa-trash"></i>')
                ->class('btn btn-xs text-primary')
                ->dispatch('delete', ['servico' => $servico])
            ,
        ];
    }

    #[\Livewire\Attributes\On('delete')]
    public function delete($servico): void
    {
        $id = $servico['id'];
        $this->js("alertaDelete($id, 'Deseja excluir <b>{$servico['descricao']}</b>?', 'deleteRow')");
    }

    #[\Livewire\Attributes\On('deleteRow')]
    public function deleteRow($id): void
    {
        $servico = Servico::find($id);
        $result = $servico->delete();

        if ($result) {
            $this->js("alertaSucesso('<b>$servico->descricao</b> excluído com sucesso')");
        } else {
            $this->js("alertaFalha('Erro ao excluir <b>$servico->descricao</b>')");
        }
    }

    /*
    public function actionRules(Servico $row): array
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
