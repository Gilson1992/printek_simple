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

    public function mount($id = null)
    {
        if ($id) {
            $this->idEquipamento = $id;
            $equipamento = EquipamentoModel::findOrFail($id);

            $this->cliente_id = $equipamento->cliente_id;
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
        $data = [
            'cliente_id' => $this->cliente_id,
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
                EquipamentoModel::find($this->idEquipamento)->update($data);
                $this->js("alertaSucesso('Equipamento editado com sucesso!')");
            } else {
                EquipamentoModel::create($data);
                $this->js("alertaSucesso('Equipamento cadastrado com sucesso!')");
            }

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
