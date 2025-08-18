<?php

namespace App\Livewire\Powergrid;

use App\Enums\{Tipo, TipoPosse};
use App\Helpers\PowerGridThemes\TailwindHeaderFixed;
use App\Models\Equipamento;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use PowerComponents\LivewirePowerGrid\{Button, Column, PowerGridFields, PowerGridComponent};
use PowerComponents\LivewirePowerGrid\Facades\{Filter, Rule, PowerGrid};

final class EquipamentoTable extends PowerGridComponent
{
    public string $tableName = 'equipamento-table';

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
            Button::add('cadastrar-equipamento')
                ->slot('Cadastrar Equipamento')
                ->class('btn btn-primary mt-2 text-bold')
                ->openModal('modal.equipamento', []),
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
            ->add('cliente_id', fn (Equipamento $model) => $model->cliente->nome)
            ->add('tipo')
            ->add('tipo_posse')
            ->add('marca')
            ->add('modelo')
            ->add('serial')
            ->add('contador')
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
            Column::make('Tipo Posse', 'tipo_posse')
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
            Filter::inputText('cliente_id')->operators([])->filterRelation('cliente', 'nome'),
            Filter::select('tipo')
                ->dataSource(collect(Tipo::cases())->map(fn($tipo) => [
                    'value' => $tipo->value,
                    'label' => $tipo->value
                ]))
                ->optionValue('value')
                ->optionLabel('label'),
            Filter::select('tipo_posse')
                ->dataSource(collect(TipoPosse::cases())->map(fn($tipo) => [
                    'value' => $tipo->value,
                    'label' => $tipo->value
                ]))
                ->optionValue('value')
                ->optionLabel('value'),
            Filter::inputText('marca')->operators([]),
            Filter::inputText('modelo')->operators([]),
            Filter::inputText('serial')->operators([]),
            Filter::inputText('contador')->operators([]),
            Filter::datepicker('created_at_formatted', 'created_at'),
        ];
    }

    public function actions(Equipamento $equipamento): array
    {
        return [
            Button::add('editar-equipamento')
                ->slot('<i class="fa fa-lg fa-fw fa-pen"></i>')
                ->class('btn btn-xs text-primary')
                ->openModal('modal.equipamento', [
                    'id' => $equipamento->id,
                ])
            ,
            Button::add('deletar-equipamento')
                ->slot('<i class="fa fa-lg fa-fw fa-trash"></i>')
                ->class('btn btn-xs text-primary')
                ->dispatch('delete', ['equipamento' => $equipamento])
            ,
        ];
    }

    #[\Livewire\Attributes\On('delete')]
    public function delete($equipamento): void
    {
        $id = $equipamento['id'];
        $this->js("alertaDelete($id, 'Deseja excluir <b>{$equipamento['modelo']}</b>?', 'deleteRow')");
    }

    #[\Livewire\Attributes\On('deleteRow')]
    public function deleteRow($id): void
    {
        $equipamento = Equipamento::find($id);
        $result = $equipamento->delete();

        if ($result) {
            $this->js("alertaSucesso('<b>$equipamento->modelo</b> excluído com sucesso')");
        } else {
            $this->js("alertaFalha('Erro ao excluir <b>$equipamento->modelo</b>')");
        }
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
