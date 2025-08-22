<?php

namespace App\Livewire\Powergrid;

use App\Enums\StatusOs;
use App\Helpers\PowerGridThemes\TailwindHeaderFixed;
use App\Models\OrdemServico;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use PowerComponents\LivewirePowerGrid\{Button, Column, PowerGridFields, PowerGridComponent};
use PowerComponents\LivewirePowerGrid\Facades\{Filter, Rule, PowerGrid};

final class OrdemServicoTable extends PowerGridComponent
{
    public string $tableName = 'ordem-servico-table';

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
            Button::add('cadastrar-os')
                ->slot('Abrir OS')
                ->class('btn btn-primary mt-2 mr-2 text-bold')
                ->openModal('modal.ordem-servico', []),
            Button::add('gerar-os')
                ->slot('Gerar OS')
                ->class('btn btn-primary mt-2 mr-2 text-bold')
                // ->openModal('modal.ordem-servico', []),
        ];
    }

    public function datasource(): Builder
    {
        return OrdemServico::query()->with(['equipamento.cliente', 'tecnico']);
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            // ->add('equipamento_formatado', fn (OrdemServico $model) =>
            //     "{$model->equipamento->marca} - {$model->equipamento->modelo} ({$model->equipamento->cliente->nome})"
            // )
            ->add('cliente', fn (OrdemServico $model) =>
                "{$model->equipamento->cliente->nome}"
            )
            ->add('equipamento_formatado', fn (OrdemServico $model) =>
                "{$model->equipamento->marca} - {$model->equipamento->modelo}"
            )
            ->add('tecnico_formatado', fn (OrdemServico $model) =>
                optional($model->tecnico)?->nome
                    ? "{$model->tecnico->nome} - {$model->tecnico->matricula}"
                    : 'Nenhum técnico associado'
            )
            ->add('data_entrada_formatada', fn (OrdemServico $model) =>
                Carbon::parse($model->data_entrada)->format('d/m/Y')
            )
            ->add('data_prevista_formatada', fn (OrdemServico $model) =>
                $model->data_prevista
                    ? Carbon::parse($model->data_prevista)->format('d/m/Y')
                    : '-'
            )
            ->add('data_conclusao_formatada', fn (OrdemServico $model) =>
                $model->data_prevista
                    ? Carbon::parse($model->data_conclusao)->format('d/m/Y')
                    : '-'
            )
            ->add('defeito_declarado')
            // ->add('defeito_encontrado')
            // ->add('solucao')
            // ->add('observacao_recebimento')
            // ->add('observacao_servico')
            // ->add('observacao_tecnico')
            ->add('contador')
            ->add('status')
            // ->add('created_at_formatado', fn (OrdemServico $model) => 
            //     Carbon::parse($model->created_at)->format('d/m/Y')
            // )
            ;
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->searchable()
                ->sortable(),
            Column::action('Ação'),
            Column::make('Cliente', 'cliente')
                ->searchable()
                ->sortable(),
            Column::make('Equipamento', 'equipamento_formatado')
                ->searchable()
                ->sortable(),
            Column::make('Técnico', 'tecnico_formatado')
                ->searchable()
                ->sortable(),
            Column::make('Data de Entrada', 'data_entrada_formatada')
                ->searchable()
                ->sortable(),
            Column::make('Data Prevista', 'data_prevista_formatada')
                ->searchable()
                ->sortable(),
            Column::make('Data Conclusão', 'data_conclusao_formatada')
                ->searchable()
                ->sortable(),
            Column::make('Defeito Declarado', 'defeito_declarado')
                ->searchable()
                ->sortable(),
            // Column::make('Defeito Encontrado', 'defeito_encontrado')
            //     ->searchable()
            //     ->sortable(),
            // Column::make('Solução', 'solucao')
            //     ->searchable()
            //     ->sortable(),
            // Column::make('Observação Recebimento', 'observacao_recebimento')
            //     ->searchable()
            //     ->sortable(),
            // Column::make('Observação Serviço', 'observacao_servico')
            //     ->searchable()
            //     ->sortable(),
            // Column::make('Observação Técnico', 'observacao_tecnico')
            //     ->searchable()
            //     ->sortable(),
            Column::make('Contador', 'contador')
                ->searchable()
                ->sortable(),
            Column::make('Status', 'status')
                ->searchable()
                ->sortable(),
            // Column::make('Criado Em', 'created_at_formatado', 'created_at')
            //     ->searchable(),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('cliente')->operators([]),
            Filter::inputText('equipamento_formatado')->operators([]),
            Filter::select('status')
                ->dataSource(collect(StatusOs::cases())->map(fn($tipo) => [
                    'value' => $tipo->value,
                    'label' => $tipo->value
                ]))
                ->optionValue('value')
                ->optionLabel('label'),
        ];
    }

    public function actions(OrdemServico $os): array
    {
        return [
            Button::add('editar-os')
                ->slot('<i class="fa fa-lg fa-fw fa-pen"></i>')
                ->class('btn btn-xs text-primary')
                ->openModal('modal.ordem-servico', [
                    'id' => $os->id,
                ])
            ,
            Button::add('deletar-os')
                ->slot('<i class="fa fa-lg fa-fw fa-trash"></i>')
                ->class('btn btn-xs text-primary')
                ->dispatch('delete', ['os' => $os])
            ,
        ];
    }

    #[\Livewire\Attributes\On('delete')]
    public function delete($os): void
    {
        $id = $os['id'];
        $this->js("alertaDelete($id, 'Deseja excluir <b>{$os['id']}</b>?', 'deleteRow')");
    }

    #[\Livewire\Attributes\On('deleteRow')]
    public function deleteRow($id): void
    {
        $os = OrdemServico::find($id);
        $result = $os->delete();

        if ($result) {
            $this->js("alertaSucesso('<b>$os->id</b> excluído com sucesso')");
        } else {
            $this->js("alertaFalha('Erro ao excluir <b>$os->id</b>')");
        }
    }

    /*
    public function actionRules(OrdemServico $row): array
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
