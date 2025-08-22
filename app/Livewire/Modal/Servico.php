<?php

namespace App\Livewire\Modal;

use App\Models\Servico as ServicoModel;
use Illuminate\Support\Facades\Log;
use LivewireUI\Modal\ModalComponent;

class Servico extends ModalComponent
{
    public $idServico;
    public $descricao;
    public $codigo;
    public $contador;
    public $preco;

    protected $listeners = [
        'setIdServico',
    ];

    public function mount($id = null)
    {
        if ($id) {
            $this->idServico = $id;
            $servico = ServicoModel::findOrFail($id);

            $this->descricao    = $servico->descricao;
            $this->codigo       = $servico->codigo;
            $this->contador     = $servico->contador;
            $this->preco = 'R$ ' . number_format($servico->preco, 2, ',', '.');
        }
    }

    public function setIdServico($data)
    {
        $this->idServico = $data;
    }

    public function salvarServico()
    {
        $precoFormatado = str_replace(['R$', '.', ','], ['', '', '.'], $this->preco);

        $data = [
            'descricao' => $this->descricao,
            'codigo'    => $this->codigo,
            'contador'  => $this->contador,
            'preco' => $precoFormatado,
        ];

        try {
            if (! $this->idServico && $this->codigo) {
                $trashed = ServicoModel::withTrashed()
                    ->where('codigo', $this->codigo)
                    ->first();

                if ($trashed && $trashed->trashed()) {
                    $trashed->restore();
                    $trashed->update($data);

                    $this->js("alertaSucesso('Serviço reativado com sucesso!')");
                    $this->dispatch('closeModal');
                    $this->dispatch('reloadPowergrid');
                    return;
                }
            }

            if ($this->idServico) {
                ServicoModel::find($this->idServico)->update($data);
                $this->js("alertaSucesso('Serviço editado com sucesso!')");
            } else {
                ServicoModel::create($data);
                $this->js("alertaSucesso('Serviço cadastrado com sucesso!')");
            }

            $this->dispatch('closeModal');
            $this->dispatch('reloadPowergrid');
        } catch (\Throwable $e) {
            // Log::error('Erro ao salvar Serviço', [
            //     'mensagem' => $e->getMessage(),
            //     'dados'    => $data,
            // ]);
            $this->js("alertaFalha('Erro ao salvar serviço. Tente novamente.')");
        }
    }

    public function render()
    {
        return view('livewire.modal.servico');
    }
}
