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
                                placeholder="xx.xxx.xxx/xxxx-xx"
                                wire:model.live="cnpj"
                                name="cnpj"
                                id="cnpj"
                                type="text"
                                igroup-size="md"
                            >
                            </x-adminlte-input>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <x-adminlte-input
                                label="Contato"
                                placeholder="(xx) xxxxx-xxxx"
                                wire:model.live="contato"
                                name="contato"
                                id="contato"
                                type="text"
                                igroup-size="md"
                            >
                            </x-adminlte-input>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <x-adminlte-input
                                label="E-mail"
                                placeholder="x@x.com"
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
                                placeholder="..."
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
                                placeholder="..."
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
</div>
