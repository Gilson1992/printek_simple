<div class="row justify-center items-center text-center">
    <div class="col-12">
        <div class="card mb-0">
            <div class="card-header">
                <span class="text-lg font-bold">Serviço</span>

                <button wire:click="$dispatch('closeModal')" class="float-right">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="card-body">
                <form wire:submit.prevent="salvarServico" id="form">
                    <div class="row">
                        <div class="col-8">
                            <x-adminlte-input
                                label="Descrição"
                                placeholder="Descrição do serviço..."
                                wire:model.live="descricao"
                                name="descricao"
                                id="descricao"
                                type="text"
                                igroup-size="md"
                            >
                            </x-adminlte-input>
                        </div>
                    
                        <div class="col-4">
                            <x-adminlte-input
                                label="Código"
                                placeholder="Código do serviço..."
                                wire:model.live="codigo"
                                name="codigo"
                                id="codigo"
                                type="text"
                                igroup-size="md"
                            >
                            </x-adminlte-input>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-4">
                            <x-adminlte-input
                                label="Contador"
                                placeholder="0"
                                wire:model.live="contador"
                                name="contador"
                                id="contador"
                                type="number"
                                igroup-size="md"
                            >
                            </x-adminlte-input>
                        </div>

                        <div class="col-4">
                            <x-adminlte-input
                                label="Preço"
                                placeholder="R$ 0,00"
                                wire:model.live="preco"
                                name="preco"
                                id="preco"
                                type="text"
                                igroup-size="md"
                                x-data
                                x-init="Inputmask({
                                    alias: 'currency',
                                    prefix: 'R$ ',
                                    groupSeparator: '.',
                                    radixPoint: ',',
                                    digits: 2,
                                    autoUnmask: true,
                                    removeMaskOnSubmit: true
                                }).mask($el)"
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
