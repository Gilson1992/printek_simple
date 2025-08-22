<?php

namespace App\Livewire\Powergrid;

use App\Helpers\PowerGridThemes\TailwindHeaderFixed;
use App\Models\Peca;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use PowerComponents\LivewirePowerGrid\{Button, Column, PowerGridFields, PowerGridComponent};
use PowerComponents\LivewirePowerGrid\Facades\{Filter, Rule, PowerGrid};

final class PecaTable extends PowerGridComponent
{
    public string $tableName = 'peca-table';

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
            Button::add('cadastrar-peca')
                ->slot('Cadastrar Peça')
                ->class('btn btn-primary mt-2 mr-2 text-bold')
                ->openModal('modal.peca', []),
        ];
    }

    public function datasource(): Builder
    {
        return Peca::query();
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('descricao')
            ->add('codigo')
            ->add('quantidade')
            ->add('unidade')
            ->add('preco_formatado', fn (Peca $model) =>
                'R$ ' . number_format($model->preco, 2, ',', '.')
            )
            ->add('ativo')
            ->add('created_at_formatado', fn (Peca $model) => Carbon::parse($model->created_at)->format('d/m/Y'));
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
            Column::make('Quantidade', 'quantidade')
                ->searchable()
                ->sortable()
                ->editOnClick(),
            Column::make('Unidade', 'unidade')
                ->searchable()
                ->sortable(),
            Column::make('Preço', 'preco_formatado')
                ->searchable()
                ->sortable(),
            Column::make('Em Estoque?', 'ativo')
                ->toggleable(
                    true,
                    'Sim',
                    'Não'
                )
                ->searchable()
                ->sortable(),
            Column::make('Criado Em', 'created_at_formatado', 'created_at')
                ->searchable(),
            Column::action('Ação')
        ];
    }

    public function onUpdatedToggleable(string|int $id, string $field, string $value): void
    {
        Peca::query()
            ->find($id)
            ->update([$field => $value]);

        $this->dispatch('reloadPowergrid');
    }

    public function onUpdatedEditable(string|int $id, string $field, string $value): void
    {
        if ($field === 'quantidade' && !is_numeric($value)) {
            $this->js("alertaFalha('Valor inválido para quantidade')");
            return;
        }

        $peca = Peca::find($id);

        if (!$peca) {
            $this->js("alertaFalha('Peça não encontrada')");
            return;
        }

        $peca->$field = e($value);

        if ($field === 'quantidade') {
            $peca->ativo = ($value > 0) ? 1 : 0;
        }

        $peca->save();

        $this->js("alertaSucesso('Quantidade de peças atualizada com sucesso!')");
        $this->dispatch('reloadPowergrid');
    }


    public function filters(): array
    {
        return [
            Filter::inputText('descricao')->operators([]),
            Filter::inputText('codigo')->operators([]),
            // Filter::inputText('quantidade')->operators([]),
            // Filter::inputText('unidade')->operators([]),
            Filter::boolean('ativo', 'ativo')->label('Sim', 'Não'),
        ];
    }

    public function actions(Peca $peca): array
    {
        return [
            Button::add('editar-peca')
                ->slot('<i class="fa fa-lg fa-fw fa-pen"></i>')
                ->class('btn btn-xs text-primary')
                ->openModal('modal.peca', [
                    'id' => $peca->id,
                ])
            ,
            Button::add('deletar-peca')
                ->slot('<i class="fa fa-lg fa-fw fa-trash"></i>')
                ->class('btn btn-xs text-primary')
                ->dispatch('delete', ['peca' => $peca])
            ,
        ];
    }

    #[\Livewire\Attributes\On('delete')]
    public function delete($peca): void
    {
        $id = $peca['id'];
        $this->js("alertaDelete($id, 'Deseja excluir <b>{$peca['descricao']}</b>?', 'deleteRow')");
    }

    #[\Livewire\Attributes\On('deleteRow')]
    public function deleteRow($id): void
    {
        $peca = Peca::find($id);
        $result = $peca->delete();

        if ($result) {
            $this->js("alertaSucesso('<b>$peca->descricao</b> excluído com sucesso')");
        } else {
            $this->js("alertaFalha('Erro ao excluir <b>$peca->descricao</b>')");
        }
    }

    /*
    public function actionRules(Peca $row): array
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
