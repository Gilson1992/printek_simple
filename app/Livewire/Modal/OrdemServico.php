<?php

namespace App\Livewire\Modal;

use App\Enums\StatusOs;
use App\Models\OrdemServico as OrdemServicoModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use LivewireUI\Modal\ModalComponent;

class OrdemServico extends ModalComponent
{
    public $idOs;
    public $equipamento_id;
    public $tecnico_id;
    public $defeito_declarado;
    public $data_entrada;
    public $data_prevista;
    public $data_conclusao;
    public $observacao_recebimento;
    public $observacao_servico;
    public $observacao_tecnico;
    public $contador;

    public $servicos = [];
    public $pecas = [];

    protected $listeners = [
        'setIdEquipamento',
        'setIdTecnico',
    ];

    public function mount($id = null)
    {
        if ($id) {
            $this->idOs = $id;
            $os = OrdemServicoModel::with(['equipamento.cliente', 'tecnico'])->findOrFail($id);

            $this->equipamento_id           = $os->equipamento_id;
            $this->tecnico_id               = $os->tecnico_id;
            $this->data_entrada             = $os->data_entrada ? Carbon::parse($os->data_entrada)->format('d/m/Y') : null;
            $this->data_prevista            = $os->data_prevista ? Carbon::parse($os->data_prevista)->format('d/m/Y') : null;
            $this->data_conclusao           = $os->data_conclusao ? Carbon::parse($os->data_conclusao)->format('d/m/Y') : null;
            $this->defeito_declarado        = $os->defeito_declarado;
            $this->observacao_recebimento   = $os->observacao_recebimento;
            $this->observacao_servico       = $os->observacao_servico;
            $this->observacao_tecnico       = $os->observacao_tecnico;
            $this->contador                 = $os->contador;

            $this->dispatch('preencherSelect2', [
                'equipamento_id' => [
                    'id' => $os->equipamento_id,
                    'text' => "{$os->equipamento->cliente->nome} ({$os->equipamento->marca} - {$os->equipamento->modelo})"
                ],
                'tecnico_id' => $os->tecnico_id
                ? [
                    'id' => $os->tecnico_id,
                    'text' => "{$os->tecnico->matricula} - {$os->tecnico->nome}"
                ] : null
            ]);

            $this->servicos = $os->servicos->map(function ($servico) {
                return [
                    'servico_id' => $servico->id,
                    'quantidade' => $servico->pivot->quantidade,
                    'valor_unitario' => number_format($servico->pivot->valor_unitario, 2, ',', '.'),
                ];
            })->toArray();

            $this->pecas = $os->pecas->map(function ($peca) {
                return [
                    'peca_id' => $peca->id,
                    'quantidade' => $peca->pivot->quantidade,
                    'valor_unitario' => number_format($peca->pivot->valor_unitario, 2, ',', '.'),
                ];
            })->toArray();
        }
    }

    public function setIdEquipamento($data)
    {
        $this->equipamento_id = $data;
    }

    public function setIdTecnico($data)
    {
        $this->tecnico_id = $data;
    }

    private function formatarData($data)
    {
        if (!$data) return null;

        try {
            return Carbon::createFromFormat('d/m/Y', $data)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }

    public function adicionarServico()
    {
        $this->servicos[] = ['servico_id' => null, 'quantidade' => 1, 'valor_unitario' => ''];
    }

    public function removerServico($index)
    {
        unset($this->servicos[$index]);
        $this->servicos = array_values($this->servicos);
    }

    public function adicionarPeca()
    {
        $this->pecas[] = ['peca_id' => null, 'quantidade' => 1, 'valor_unitario' => ''];
    }

    public function removerPeca($index)
    {
        unset($this->pecas[$index]);
        $this->pecas = array_values($this->pecas);
    }

    #[\Livewire\Attributes\On('atualizarServicoSelecionado')]
    public function atualizarServicoSelecionado($data)
    {
        $this->servico[$data['index']]['servico_id'] = $data['servicoId'];
    }

    #[\Livewire\Attributes\On('atualizarPecaSelecionada')]
    public function atualizarPecaSelecionada($data)
    {
        $this->pecas[$data['index']]['peca_id'] = $data['pecaId'];
    }

    public function salvarOs()
    {
        $data = [
            'equipamento_id'            => $this->equipamento_id,
            'tecnico_id'                => $this->tecnico_id,
            'data_entrada'              => $this->formatarData($this->data_entrada),
            'data_prevista'             => $this->formatarData($this->data_prevista),
            'data_conclusao'            => $this->formatarData($this->data_conclusao),
            'defeito_declarado'         => $this->defeito_declarado,
            'observacao_recebimento'    => $this->observacao_recebimento,
            'observacao_servico'        => $this->observacao_servico,
            'observacao_tecnico'        => $this->observacao_tecnico,
            'contador'                  => $this->contador,
            'status'                    => StatusOs::Aberta,
        ];

        try {
            $ordemServico = $this->idOs
                ? OrdemServicoModel::findOrFail($this->idOs)
                : OrdemServicoModel::create($data);

            if ($this->idOs) {
                $ordemServico->update($data);
            }

            $ordemServico->servicos()->detach();
            foreach ($this->servicos as $servico) {
                $valorUnitario = floatval(str_replace(['.', ','], ['', '.'], $servico['valor_unitario'] ?? 0));
                $quantidade = (int) ($servico['quantidade'] ?? 1);
                $ordemServico->servicos()->attach($servico['servico_id'], [
                    'quantidade' => $quantidade,
                    'valor_unitario' => $valorUnitario,
                    'valor_total' => $valorUnitario * $quantidade,
                ]);
            }

            $ordemServico->pecas()->detach();
            foreach ($this->pecas as $peca) {
                $valorUnitario = floatval(str_replace(['.', ','], ['', '.'], $peca['valor_unitario'] ?? 0));
                $quantidade = (int) ($peca['quantidade'] ?? 1);
                $ordemServico->pecas()->attach($peca['peca_id'], [
                    'quantidade' => $quantidade,
                    'valor_unitario' => $valorUnitario,
                    'valor_total' => $valorUnitario * $quantidade,
                ]);
            }

            $this->js("alertaSucesso('OS " . ($this->idOs ? 'editada' : 'cadastrada') . " com sucesso!')");
            $this->dispatch('closeModal');
            $this->dispatch('reloadPowergrid');

        } catch (\Throwable $e) {
            // Log::error('Erro ao salvar OS', [
            //     'mensagem' => $e->getMessage(),
            //     'dados'    => $data,
            //     'servicos' => $this->servicos,
            //     'pecas'    => $this->pecas,
            // ]);
            $this->js("alertaFalha('Erro ao salvar OS. Tente novamente.')");
        }
    }

    public function render()
    {
        return view('livewire.modal.ordem-servico');
    }
}
