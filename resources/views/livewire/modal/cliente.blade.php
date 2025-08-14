<div class="row justify-center items-center text-center">
    <div class="col-12">
        <div class="card mb-0">
            <div class="card-header">
                <span class="text-lg font-bold">Cliente</span>

                <button wire:click="$dispatch('closeModal')" class="float-right">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="card-body">
                <form wire:submit.prevent="salvarCliente" id="form">
                    <div class="row">
                        <div class="col-12">
                            <x-adminlte-input
                                label="Nome"
                                placeholder="Nome do cliente..."
                                wire:model.live="nome"
                                name="nome"
                                id="nome"
                                type="text"
                                igroup-size="md"
                            >
                            </x-adminlte-input>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <x-adminlte-input
                                label="CNPJ"
                                placeholder="__.___.___/____-__"
                                wire:model.live="cnpj"
                                name="cnpj"
                                id="cnpj"
                                type="text"
                                igroup-size="md"
                                x-data
                                x-init="Inputmask('99.999.999/9999-99').mask($el)"
                                x-on:blur="$js.buscarCnpj($el.value)"
                                x-on:input="($el.value.replace(/\D/g,'').length === 14) && $js.buscarCnpj($el.value)"
                            />
                            {{-- </x-adminlte-input> --}}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <x-adminlte-input
                                label="Contato"
                                placeholder="(__) _____-____"
                                wire:model.live="contato"
                                name="contato"
                                id="contato"
                                type="text"
                                igroup-size="md"
                                x-data
                                x-init="Inputmask('(99) 99999-9999').mask($el)"
                            >
                            </x-adminlte-input>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <x-adminlte-input
                                label="E-mail"
                                placeholder="cliente@dominio.com"
                                wire:model.live="email"
                                name="email"
                                id="email"
                                type="text"
                                igroup-size="md"
                            >
                            </x-adminlte-input>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <x-adminlte-input
                                label="Endereço"
                                placeholder=""
                                wire:model.live="endereco"
                                name="endereco"
                                id="endereco"
                                type="text"
                                igroup-size="md"
                            >
                            </x-adminlte-input>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <x-adminlte-input
                                label="Observação"
                                placeholder="Informações extras..."
                                wire:model.live="observacao"
                                name="observacao"
                                id="observacao"
                                type="text"
                                igroup-size="md"
                            >
                            </x-adminlte-input>
                        </div>
                    </div>
                </form>
            </div>

            <div class="card-footer">
                <div class="row flex justify-between">
                    <div class="col-3 p-0 flex justify-start">
                        <button class="btn btn-primary" type="submit" form="form">
                            <i class="fas fa-lg fa-save"></i> Salvar
                        </button>
                    </div>

                    <div class="col-3 p-0 flex justify-end">
                        <button wire:click.prevent="$dispatch('closeModal')" class="btn btn-primary">
                            <i class="fas fa-ban"></i> Cancelar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @script
        <script>
            let isFetchingCnpj = false;

            function toast({ icon = 'info', title = '' }) {
                Swal.fire({
                    icon,
                    title,
                    toast: true,
                    position: 'top-end',
                    timer: 2500,
                    timerProgressBar: true,
                    showConfirmButton: false,
                });
            }

            $js('buscarCnpj', async (valor) => {
                const raw = String(valor || '').replace(/\D/g, '');
                if (raw.length !== 14 || isFetchingCnpj) return;

                isFetchingCnpj = true;

                Swal.fire({
                    title: 'Consultando CNPJ...',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    },
                });

                try {
                    const res = await fetch(`https://brasilapi.com.br/api/cnpj/v1/${raw}`);
                    if (!res.ok) {
                        Swal.close();
                        toast({ icon: 'error', title: 'CNPJ não encontrado' });
                        return;
                    }

                    const d = await res.json();

                    const nomeAtual     = $wire.get('nome');
                    const enderecoAtual = $wire.get('endereco');
                    const emailAtual    = $wire.get('email');
                    const contatoAtual  = $wire.get('contato');

                    const nomeApi = d?.razao_social || d?.nome_fantasia || null;
                    if (nomeApi && !nomeAtual) $wire.set('nome', nomeApi);

                    const enderecoApi = [
                        d?.logradouro, d?.numero, d?.bairro, d?.municipio, d?.uf, d?.cep
                    ].filter(Boolean).join(', ');
                    if (enderecoApi && !enderecoAtual) $wire.set('endereco', enderecoApi);

                    if (d?.email && !emailAtual) $wire.set('email', d.email);

                    const telApi = String(d?.ddd_telefone_1 || '').replace(/\D/g, '');
                    if (telApi && !contatoAtual) $wire.set('contato', telApi);

                    Swal.close();

                    toast({ icon: 'success', title: 'Dados do CNPJ importados' });

                } catch (e) {
                    console.error('BrasilAPI CNPJ error:', e);
                    Swal.close();
                    toast({ icon: 'error', title: 'Erro ao consultar CNPJ' });
                } finally {
                    isFetchingCnpj = false;
                }
            });
        </script>
    @endscript

</div>
