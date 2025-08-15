<div class="row justify-center items-center text-center">
    <div class="col-12">
        <div class="card mb-0">
            <div class="card-header">
                <span class="text-lg font-bold">Técnico</span>

                <button wire:click="$dispatch('closeModal')" class="float-right">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="card-body">
                <form wire:submit.prevent="salvarTecnico" id="form">
                    <div class="row">
                        <div class="col-3">
                            <x-adminlte-input
                                label="Matrícula"
                                placeholder="Identificação..."
                                wire:model.live="matricula"
                                name="matricula"
                                id="matricula"
                                type="text"
                                igroup-size="md"
                            >
                            </x-adminlte-input>
                        </div>

                        <div class="col-9">
                            <x-adminlte-input
                                label="Nome"
                                placeholder="Nome do técnico..."
                                wire:model.live="nome"
                                name="nome"
                                id="nome"
                                type="text"
                                igroup-size="md"
                            >
                            </x-adminlte-input>
                        </div>
                    </div>

                    @php
                        use App\Enums\Disponibilidade;
                    @endphp

                    <div class="row">
                        <div class="col-3">
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

                        <div class="col-9">
                            <x-adminlte-select
                                label="Disponibilidade"
                                data-placeholder="Selecione a disponibilidade..."
                                wire:model.defer="disponibilidade"
                                name="disponibilidade"
                                id="disponibilidade"
                                igroup-size="md"
                            >
                                <option value="">-- selecione --</option>
                                @foreach(Disponibilidade::cases() as $case)
                                    <option value="{{ $case->value }}">{{ $case->value }}</option>
                                @endforeach
                            </x-adminlte-select>
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
