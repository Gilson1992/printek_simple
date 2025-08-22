<div class="row justify-center items-center text-center">
    <div class="col-12">
        <div class="card mb-0">
            <div class="card-header">
                <span class="text-lg font-bold">Equipamento</span>

                <button wire:click="$dispatch('closeModal')" class="float-right">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="card-body">
                <form wire:submit.prevent="salvarEquipamento" id="form">
                    <div class="row">
                        <div class="col-12" wire:ignore>
                            <x-adminlte-select2
                                label="Cliente"
                                wire:model.live="cliente_id"
                                name="cliente_id"
                                class="clientes"
                                id="cliente_id"
                                igroup-size="md"
                                multiple
                            >
                            </x-adminlte-select2>
                        </div>
                    </div>

                    @php
                        use App\Enums\Tipo;
                        use App\Enums\TipoPosse;
                    @endphp

                    <div class="row">
                        <div class="col-6">
                            <x-adminlte-select
                                label="Tipo"
                                data-placeholder="Selecione o tipo..."
                                wire:model.defer="tipo"
                                name="tipo"
                                id="tipo"
                                igroup-size="md"
                            >
                                <option value="">-- selecione --</option>
                                @foreach(Tipo::cases() as $case)
                                    <option value="{{ $case->value }}">{{ $case->value }}</option>
                                @endforeach
                            </x-adminlte-select>
                        </div>

                        <div class="col-6">
                            <x-adminlte-select
                                label="Tipo de Posse"
                                data-placeholder="Selecione o tipo de posse..."
                                wire:model.defer="tipo_posse"
                                name="tipo_posse"
                                id="tipo_posse"
                                igroup-size="md"
                            >
                                <option value="">-- selecione --</option>
                                @foreach(TipoPosse::cases() as $case)
                                    <option value="{{ $case->value }}">{{ $case->value }}</option>
                                @endforeach
                            </x-adminlte-select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <x-adminlte-input
                                label="Marca"
                                placeholder=""
                                wire:model.live="marca"
                                name="marca"
                                id="marca"
                                type="text"
                                igroup-size="md"
                            >
                            </x-adminlte-input>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <x-adminlte-input
                                label="Modelo"
                                placeholder=""
                                wire:model.live="modelo"
                                name="modelo"
                                id="modelo"
                                type="text"
                                igroup-size="md"
                            >
                            </x-adminlte-input>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <x-adminlte-input
                                label="Serial"
                                placeholder=""
                                wire:model.live="serial"
                                name="serial"
                                id="serial"
                                type="text"
                                igroup-size="md"
                            >
                            </x-adminlte-input>
                        </div>

                        <div class="col-6">
                            <x-adminlte-input
                                label="Contador"
                                placeholder=""
                                wire:model.live="contador"
                                name="contador"
                                id="contador"
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
                                placeholder=""
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
                        <button class="btn btn-orange text-bold" type="submit" form="form">
                            <i class="fas fa-lg fa-save"></i> Salvar
                        </button>
                    </div>

                    <div class="col-3 p-0 flex justify-end">
                        <button wire:click.prevent="$dispatch('closeModal')" class="btn btn-secondary text-bold">
                            <i class="fas fa-ban"></i> Cancelar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @script
        <script>
             $(document).ready(function() {
                $(".clientes").select2({
                    language: 'pt-BR',
                    placeholder: 'Selecione o cliente...',
                    maximumSelectionLength: 1,
                    ajax: {
                        url: "{{ route('clientes.paginate') }}",
                        delay: 1000,
                        data: function (params) {
                            var query = {
                                search: params.term,
                                page: params.page || 1
                            }
                            return query;
                        },
                        processResults: function (data, params) {
                            params.page = params.page || 1;
                            return {
                                results: data.data,
                                pagination: {
                                    more: (params.page * 10) < data.total
                                }
                            };
                        }
                    }
                });
                $('.clientes').on('select2:select', function (e) {
                    var data = $('.clientes').select2("data");
                    $wire.dispatch('setIdCliente', {data: data[0].id});
                });
            });
        </script>
    @endscript
</div>
