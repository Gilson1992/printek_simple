<?php

namespace App\Livewire\Modal;

use App\Models\Cliente as ClienteModel;
use Illuminate\Support\Facades\Log;
use LivewireUI\Modal\ModalComponent;

class Cliente extends ModalComponent
{
    public $idCliente;
    public $nome;
    public $cnpj;
    public $contato;
    public $email;
    public $endereco;
    public $observacao;

    public function rules()
    {
        $cleanCnpj = preg_replace('/\D/', '', $this->cnpj ?? '');
        $cleanContato = preg_replace('/\D/', '', $this->contato ?? '');

        return [
            'nome'     => 'required|string|max:150',
            'cnpj' => [
            'nullable',
                function ($attribute, $value, $fail) use ($cleanCnpj) {
                    if ($cleanCnpj && strlen($cleanCnpj) !== 14) {
                        $fail('O CNPJ deve conter exatamente 14 números.');
                    }
                },
            ],

            'contato' => [
                'nullable',
                function ($attribute, $value, $fail) use ($cleanContato) {
                    if ($cleanContato && !in_array(strlen($cleanContato), [10, 11])) {
                        $fail('O número de contato deve conter 10 (fixo) ou 11 (celular) dígitos.');
                    }
                },
            ],
            'email'    => 'nullable|email|max:180|unique:clientes,email,' . $this->idCliente . ',id,deleted_at,NULL',
            'endereco' => 'nullable|string|max:255',
            'observacao' => 'nullable|string|max:65535',
        ];
    }

    protected function messages()
    {
        return [
            'nome.required' => 'O nome é obrigatório.',
            'cnpj.digits'   => 'O CNPJ deve conter 14 números.',
            'cnpj.unique'   => 'Este CNPJ já está cadastrado.',
            'contato'       => 'O número de contato deve conter entre 10 e 11 dígitos (com DDD).',
            'email'         => 'Insira um e-mail válido (email@domino.com).',
        ];
    }

    public function mount($id = null)
    {
        if ($id) {
            $this->idCliente = $id;
            $cliente         = ClienteModel::findOrFail($id);

            $this->nome       = $cliente->nome;
            $this->cnpj       = $cliente->cnpj;
            $this->contato    = $cliente->contato;
            $this->email      = $cliente->email;
            $this->endereco   = $cliente->endereco;
            $this->observacao = $cliente->observacao;
        }
    }

    public function salvarCliente()
    {
        $this->validate();

        $cleanCnpj    = preg_replace('/\D/', '', $this->cnpj) ?: null;
        $cleanContato = preg_replace('/\D/', '', $this->contato) ?: null;
        $cleanEmail   = trim($this->email) ?: null;

        $data = [
            'nome'       => $this->nome,
            'cnpj'       => $cleanCnpj,
            'contato'    => $cleanContato,
            'email'      => $cleanEmail,
            'endereco'   => $this->endereco,
            'observacao' => $this->observacao,
        ];

        try {
            if (! $this->idCliente && $cleanCnpj) {
                $trashed = ClienteModel::withTrashed()
                    ->where('cnpj', $cleanCnpj)
                    ->first();

                if ($trashed && $trashed->trashed()) {
                    $trashed->restore();
                    $trashed->update($data);

                    $this->js("alertaSucesso('Cliente reativado com sucesso!')");
                    $this->dispatch('closeModal');
                    $this->dispatch('reloadPowergrid');
                    return;
                }
            }

            if (! $this->idCliente && $cleanEmail) {
                $trashed = ClienteModel::withTrashed()
                    ->where('email', $cleanEmail)
                    ->first();

                if ($trashed && $trashed->trashed()) {
                    $trashed->restore();
                    $trashed->update($data);

                    $this->js("alertaSucesso('Cliente reativado com sucesso!')");
                    $this->dispatch('closeModal');
                    $this->dispatch('reloadPowergrid');
                    return;
                }
            }

            if ($this->idCliente) {
                ClienteModel::find($this->idCliente)->update($data);
                $this->js("alertaSucesso('Cliente editado com sucesso!')");
            } else {
                ClienteModel::create($data);
                $this->js("alertaSucesso('Cliente cadastrado com sucesso!')");
            }

            $this->dispatch('closeModal');
            $this->dispatch('reloadPowergrid');
        } catch (\Throwable $e) {
            // Log::error('Erro ao salvar Cliente', [
            //     'mensagem' => $e->getMessage(),
            //     'dados'    => $data,
            // ]);
            if ($cleanCnpj === $data['cnpj']) {
                $this->js("alertaAviso('Cliente já cadastrado.')");
            } else {
                $this->js("alertaFalha('Erro ao salvar cliente. Tente novamente.')");
            }
        }
    }

    public function render()
    {
        return view('livewire.modal.cliente');
    }
}
