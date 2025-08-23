<?php

namespace App\Livewire\Modal;

use App\Models\Tecnico as TecnicoModel;
use Illuminate\Support\Facades\Log;
use LivewireUI\Modal\ModalComponent;

class Tecnico extends ModalComponent
{
    public $idTecnico;
    public $matricula;
    public $nome;
    public $contato;
    public $disponibilidade;

    protected $listeners = [
        'setIdTecnico',
    ];

    public function mount($id = null)
    {
        if ($id) {
            $this->idTecnico = $id;
            $tecnico = TecnicoModel::findOrFail($id);

            $this->matricula       = $tecnico->matricula;
            $this->nome            = $tecnico->nome;
            $this->contato         = $tecnico->contato;
            $this->disponibilidade = $tecnico->disponibilidade;
        }
    }

    public function setIdTecnico($data)
    {
        $this->idTecnico = $data;
    }

    public function salvarTecnico()
    {
        $data = [
            'matricula'       => $this->matricula,
            'nome'            => $this->nome,
            'contato'         => $this->contato,
            'disponibilidade' => $this->disponibilidade,
        ];

        try {
            if (! $this->idTecnico && $this->matricula) {
                $trashed = TecnicoModel::withTrashed()
                    ->where('matricula', $this->matricula)
                    ->first();

                if ($trashed && $trashed->trashed()) {
                    $trashed->restore();
                    $trashed->update($data);

                    $this->js("alertaSucesso('Tecnico reativado com sucesso!')");
                    $this->dispatch('closeModal');
                    $this->dispatch('reloadPowergrid');
                    return;
                }
            }

            if ($this->idTecnico) {
                TecnicoModel::find($this->idTecnico)->update($data);
                $this->js("alertaSucesso('Técnico editado com sucesso!')");
            } else {
                TecnicoModel::create($data);
                $this->js("alertaSucesso('Técnico cadastrado com sucesso!')");
            }

            $this->dispatch('closeModal');
            $this->dispatch('reloadPowergrid');
        } catch (\Throwable $e) {
            // Log::error('Erro ao salvar Técnico', [
            //     'mensagem' => $e->getMessage(),
            //     'dados'    => $data,
            // ]);
            $this->js("alertaFalha('Erro ao salvar técnico. Tente novamente.')");
        }
    }

    public function render()
    {
        return view('livewire.modal.tecnico');
    }
}
