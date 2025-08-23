<?php

namespace App\Livewire\Modal;

use App\Models\Peca as PecaModel;
use Illuminate\Support\Facades\Log;
use LivewireUI\Modal\ModalComponent;

class Peca extends ModalComponent
{
    public $idPeca;
    public $descricao;
    public $codigo;
    public $quantidade;
    public $unidade;
    public $preco;

    protected $listeners = [
        'setIdPeca',
    ];

    public function mount($id = null)
    {
        if ($id) {
            $this->idPeca = $id;
            $peca = PecaModel::findOrFail($id);

            $this->descricao    = $peca->descricao;
            $this->codigo       = $peca->codigo;
            $this->quantidade   = $peca->quantidade;
            $this->unidade      = $peca->unidade;
            $this->preco = 'R$ ' . number_format($peca->preco, 2, ',', '.');
        }
    }

    public function setIdPeca($data)
    {
        $this->idPeca = $data;
    }

    public function salvarPeca()
    {
        $precoFormatado = str_replace(['R$', '.', ','], ['', '', '.'], $this->preco);

        $data = [
            'descricao'     => $this->descricao,
            'codigo'        => $this->codigo,
            'quantidade'    => $this->quantidade,
            'unidade'       => $this->unidade,
            'preco'         => $precoFormatado,
        ];

        try {
            if (! $this->idPeca && $this->codigo) {
                $trashed = PecaModel::withTrashed()
                    ->where('codigo', $this->codigo)
                    ->first();

                if ($trashed && $trashed->trashed()) {
                    $trashed->restore();
                    $trashed->update($data);

                    $this->js("alertaSucesso('Peça reativada com sucesso!')");
                    $this->dispatch('closeModal');
                    $this->dispatch('reloadPowergrid');
                    return;
                }
            }

            if ($this->idPeca) {
                PecaModel::find($this->idPeca)->update($data);
                $this->js("alertaSucesso('Peça editada com sucesso!')");
            } else {
                PecaModel::create($data);
                $this->js("alertaSucesso('Peça cadastrada com sucesso!')");
            }

            $this->dispatch('closeModal');
            $this->dispatch('reloadPowergrid');
        } catch (\Throwable $e) {
            // Log::error('Erro ao salvar Peça', [
            //     'mensagem' => $e->getMessage(),
            //     'dados'    => $data,
            // ]);
            $this->js("alertaFalha('Erro ao salvar peça. Tente novamente.')");
        }
    }

    public function render()
    {
        return view('livewire.modal.peca');
    }
}
