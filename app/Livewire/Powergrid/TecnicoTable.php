<?php

namespace App\Livewire\Powergrid;

use App\Enums\Disponibilidade;
use App\Helpers\PowerGridThemes\TailwindHeaderFixed;
use App\Models\Tecnico;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use PowerComponents\LivewirePowerGrid\{Button, Column, PowerGridFields, PowerGridComponent};
use PowerComponents\LivewirePowerGrid\Facades\{Filter, Rule, PowerGrid};

final class TecnicoTable extends PowerGridComponent
{
    public string $tableName = 'tecnico-table';

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
            Button::add('cadastrar-tecnico')
                ->slot('Cadastrar Técnico')
                ->class('btn btn-orange mt-2 mr-2 text-bold')
                ->openModal('modal.tecnico', []),
        ];
    }

    public function datasource(): Builder
    {
        return Tecnico::query();
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('matricula')
            ->add('nome')
            ->add('contato')
            ->add('disponibilidade')
            ->add('created_at_formatado', fn (Tecnico $model) => Carbon::parse($model->created_at)->format('d/m/Y'));
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->searchable()
                ->sortable(),
            Column::make('Matrícula', 'matricula')
                ->searchable()
                ->sortable(),
            Column::make('Nome', 'nome')
                ->searchable()
                ->sortable(),
            Column::make('Contato', 'contato')
                ->searchable()
                ->sortable(),
            Column::make('Disponibilidade', 'disponibilidade')
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
            Filter::inputText('matricula')->operators([]),
            Filter::inputText('nome')->operators([]),
            Filter::inputText('contato')->operators([]),
            Filter::select('disponibilidade')
                ->dataSource(collect(Disponibilidade::cases())->map(fn($tipo) => [
                    'value' => $tipo->value,
                    'label' => $tipo->value
                ]))
                ->optionValue('value')
                ->optionLabel('label'),
            Filter::datepicker('created_at_formatado', 'created_at'),
        ];
    }

    public function actions(Tecnico $tecnico): array
    {
        return [
            Button::add('editar-tecnico')
                ->slot('<i class="fa fa-lg fa-fw fa-pen"></i>')
                ->class('btn btn-xs text-orange')
                ->openModal('modal.tecnico', [
                    'id' => $tecnico->id,
                ])
            ,
            Button::add('deletar-tecnico')
                ->slot('<i class="fa fa-lg fa-fw fa-trash"></i>')
                ->class('btn btn-xs text-orange')
                ->dispatch('delete', ['tecnico' => $tecnico])
            ,
        ];
    }

    #[\Livewire\Attributes\On('delete')]
    public function delete($tecnico): void
    {
        $id = $tecnico['id'];
        $this->js("alertaDelete($id, 'Deseja excluir <b>{$tecnico['nome']}</b>?', 'deleteRow')");
    }

    #[\Livewire\Attributes\On('deleteRow')]
    public function deleteRow($id): void
    {
        $tecnico = Tecnico::find($id);
        $result = $tecnico->delete();

        if ($result) {
            $this->js("alertaSucesso('<b>$tecnico->nome</b> excluído com sucesso')");
        } else {
            $this->js("alertaFalha('Erro ao excluir <b>$tecnico->nome</b>')");
        }
    }

    /*
    public function actionRules(Tecnico $row): array
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
