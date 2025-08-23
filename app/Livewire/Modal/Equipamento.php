<?php

namespace App\Livewire\Modal;

use App\Models\Equipamento as EquipamentoModel;
use Illuminate\Support\Facades\Log;
use LivewireUI\Modal\ModalComponent;

class Equipamento extends ModalComponent
{
    public $idEquipamento;
    public $cliente_id;
    public $tipo;
    public $tipo_posse;
    public $marca;
    public $modelo;
    public $serial;
    public $contador;
    public $observacao;

    protected $listeners = [
        'setIdCliente',
    ];

    public function rules()
    {
        return [
            'tipo' => 'required|string|max:50',
            'tipo_posse' => 'required|string|max:20',
            'marca' => 'required|string|max:50',
            'modelo' => 'required|string|max:100',
            'serial' => 'required|string|max:100|unique:equipamentos,serial,' . $this->idEquipamento,
            'contador' => 'nullable|integer|min:0',
            'observacao' => 'nullable|string|max:500',
        ];
    }

    public function messages()
    {
        return [
            'cliente_id.required' => 'Selecione um cliente.',
            'tipo.required' => 'Informe o tipo do equipamento.',
            'tipo_posse.required' => 'Informe o tipo de posse.',
            'marca.required' => 'Informe a marca.',
            'modelo.required' => 'Informe o modelo.',
            'serial.required' => 'Informe o número de série.',
            'serial.unique' => 'Este número de série já está cadastrado.',
            'contador.integer' => 'O contador deve ser um número inteiro.',
            'contador.min' => 'O contador não pode ser negativo.',
        ];
    }

    public function mount($id = null)
    {
        if ($id) {
            $this->idEquipamento = $id;
            $equipamento = EquipamentoModel::findOrFail($id);

            $this->cliente_id = optional($equipamento->clientes()->first())->id;
            $this->tipo       = $equipamento->tipo;
            $this->tipo_posse = $equipamento->tipo_posse;
            $this->marca      = $equipamento->marca;
            $this->modelo     = $equipamento->modelo;
            $this->serial     = $equipamento->serial;
            $this->contador   = $equipamento->contador;
            $this->observacao = $equipamento->observacao;
        }
    }

    public function setIdCliente($data)
    {
        $this->cliente_id = $data;
    }

    public function salvarEquipamento()
    {
        $this->validate();

        $data = [
            'tipo'       => $this->tipo,
            'tipo_posse' => $this->tipo_posse,
            'marca'      => $this->marca,
            'modelo'     => $this->modelo,
            'serial'     => $this->serial,
            'contador'   => $this->contador,
            'observacao' => $this->observacao,
        ];

        try {
            if ($this->idEquipamento) {
                $equipamento = EquipamentoModel::findOrFail($this->idEquipamento);
                $equipamento->update($data);
            } else {
                $equipamento = EquipamentoModel::create($data);
            }

            if ($this->cliente_id) {
                $equipamento->clientes()->syncWithoutDetaching([$this->cliente_id]);
            }

            $mensagem = $this->idEquipamento ? 'Equipamento editado com sucesso!' : 'Equipamento cadastrado com sucesso!';
            $this->js("alertaSucesso('$mensagem')");

            $this->dispatch('closeModal');
            $this->dispatch('reloadPowergrid');
        } catch (\Throwable $e) {
            // Log::error('Erro ao salvar Equipamento', [
            //     'mensagem' => $e->getMessage(),
            //     'dados'    => $data,
            // ]);
            $this->js("alertaFalha('Erro ao salvar cliente. Tente novamente.')");
        }
    }

    public function render()
    {
        return view('livewire.modal.equipamento');
    }
}
