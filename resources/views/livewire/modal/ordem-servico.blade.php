<div class="row justify-center items-center text-center">
    <div class="col-12">
        <div class="card mb-0">
            <div class="card-header">
                <span class="text-lg font-bold">Ordem de Serviço</span>

                <button wire:click="$dispatch('closeModal')" class="float-right">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="card-body">
                <form wire:submit.prevent="salvarOs" id="form">
                    <div class="row">
                        <div class="col-12" wire:ignore>
                            <x-adminlte-select2
                                label="Equipamento *"
                                wire:model.live="equipamento_id"
                                name="equipamento_id"
                                class="equipamentos"
                                id="equipamento_id"
                                igroup-size="md"
                                multiple
                            >
                            </x-adminlte-select2>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12" wire:ignore>
                            <x-adminlte-select2
                                label="Técnico"
                                wire:model.live="tecnico_id"
                                name="tecnico_id"
                                class="tecnicos"
                                id="tecnico_id"
                                igroup-size="md"
                                multiple
                            >
                            </x-adminlte-select2>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-4">
                            <x-adminlte-input
                                label="Data Abertura"
                                placeholder="dd/mm/aaaa"
                                wire:model.live="data_entrada"
                                name="data_entrada"
                                id="data_entrada"
                                class="flatpickr"
                                igroup-size="md"
                            >
                            </x-adminlte-input>
                        </div>

                        <div class="col-4">
                            <x-adminlte-input
                                label="Data Prevista"
                                placeholder="dd/mm/aaaa"
                                wire:model.live="data_prevista"
                                name="data_prevista"
                                id="data_prevista"
                                class="flatpickr"
                                igroup-size="md"
                            >
                            </x-adminlte-input>
                        </div>

                        <div class="col-4">
                            <x-adminlte-input
                                label="Data Prevista"
                                placeholder="dd/mm/aaaa"
                                wire:model.live="data_conclusao"
                                name="data_conclusao"
                                id="data_conclusao"
                                class="flatpickr"
                                igroup-size="md"
                            >
                            </x-adminlte-input>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <x-adminlte-input
                                label="Problema"
                                placeholder="Informe o problema do equipamento..."
                                wire:model.live="defeito_declarado"
                                name="defeito_declarado"
                                id="defeito_declarado"
                                type="text"
                                igroup-size="md"
                            >
                            </x-adminlte-input>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <span class="font-bold">Serviço</span>

                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Descrição</th>
                                        <th>Qtd</th>
                                        <th>Valor Unitário</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($servicos as $index => $servico)
                                    <tr>
                                        <td>
                                            <x-adminlte-select2 wire:model.defer="servicos.{{ $index }}.servico_id" name="servicos[{{ $index }}][servico_id]" igroup-size="sm">
                                                <option value="">Selecione</option>
                                                @foreach (\App\Models\Servico::all() as $s)
                                                    <option value="{{ $s->id }}">{{ $s->descricao }} ({{ $s->codigo }})</option>
                                                @endforeach
                                            </x-adminlte-select2>
                                        </td>
                                        <td>
                                            <input type="number" wire:model.defer="servicos.{{ $index }}.quantidade" class="form-control">
                                        </td>
                                        <td>
                                            <input type="text" wire:model.defer="servicos.{{ $index }}.valor_unitario" class="form-control" placeholder="R$ 0,00">
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger btn-sm" wire:click="removerServico({{ $index }})">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <button type="button" class="btn btn-success btn-sm mb-3" wire:click="adicionarServico">
                                <i class="fas fa-plus"></i> Adicionar Serviço
                            </button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <span class="font-bold">Peça</span>

                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Descrição</th>
                                        <th>Qtd</th>
                                        <th>Valor Unitário</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pecas as $index => $peca)
                                    <tr>
                                        <td>
                                            <x-adminlte-select2 wire:model.defer="pecas.{{ $index }}.peca_id" name="pecas[{{ $index }}][peca_id]" igroup-size="sm">
                                                <option value="">Selecione</option>
                                                @foreach (\App\Models\Peca::where('ativo', true)->get() as $p)
                                                    <option value="{{ $p->id }}">{{ $p->descricao }} ({{ $p->codigo }})</option>
                                                @endforeach
                                            </x-adminlte-select2>
                                        </td>
                                        <td>
                                            <input type="number" wire:model.defer="pecas.{{ $index }}.quantidade" class="form-control">
                                        </td>
                                        <td>
                                            <input type="text" wire:model.defer="pecas.{{ $index }}.valor_unitario" class="form-control" placeholder="R$ 0,00">
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger btn-sm" wire:click="removerPeca({{ $index }})">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <button type="button" class="btn btn-success btn-sm mb-3" wire:click="adicionarPeca">
                                <i class="fas fa-plus"></i> Adicionar Peça
                            </button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <x-adminlte-input
                                label="Observações do Recebimento"
                                placeholder="Informações do recebimento do equipamento..."
                                wire:model.live="observacao_recebimento"
                                name="observacao_recebimento"
                                id="observacao_recebimento"
                                type="text"
                                igroup-size="md"
                            >
                            </x-adminlte-input>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <x-adminlte-input
                                label="Observações do Serviço"
                                placeholder="Informações sobre o serviço..."
                                wire:model.live="observacao_servico"
                                name="observacao_servico"
                                id="observacao_servico"
                                type="text"
                                igroup-size="md"
                            >
                            </x-adminlte-input>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <x-adminlte-input
                                label="Observações do Técnico"
                                placeholder="Informações do técnico..."
                                wire:model.live="observacao_tecnico"
                                name="observacao_tecnico"
                                id="observacao_tecnico"
                                type="text"
                                igroup-size="md"
                            >
                            </x-adminlte-input>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-4">
                            <x-adminlte-input
                                label="Contador Total"
                                placeholder="Número de impressões..."
                                wire:model.live="contador"
                                name="contador"
                                id="contador"
                                type="number"
                                igroup-size="md"
                            >
                            </x-adminlte-input>
                        </div>

                        {{-- <div class="col-8">
                            <x-adminlte-input
                                label="Status"
                                wire:model.live="status"
                                name="status"
                                id="status"
                                type="text"
                                igroup-size="md"
                                disable
                            >
                            </x-adminlte-input>
                        </div> --}}
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
             $(document).ready(function() {
                $(".equipamentos").select2({
                    language: 'pt-BR',
                    placeholder: 'Selecione o equipamento do cliente...',
                    maximumSelectionLength: 1,
                    ajax: {
                        url: "{{ route('equipamentos.paginate') }}",
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
                $('.equipamentos').on('select2:select', function (e) {
                    var data = $('.equipamentos').select2("data");
                    $wire.dispatch('setIdEquipamento', {data: data[0].id});
                });
            });
        </script>
    @endscript

    @script
        <script>
             $(document).ready(function() {
                $(".tecnicos").select2({
                    language: 'pt-BR',
                    placeholder: 'Selecione o técnico...',
                    maximumSelectionLength: 1,
                    ajax: {
                        url: "{{ route('tecnicos.paginate') }}",
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
                            results: data,
                            pagination: {
                                more: (params.page * 10) < data.total
                            }
                        };
                    }
                    }
                });
                $('.tecnicos').on('select2:select', function (e) {
                    var data = $('.tecnicos').select2("data");
                    $wire.dispatch('setIdTecnico', {data: data[0].id});
                });
            });
        </script>
    @endscript

    @script
        <script>
            $(document).ready(function() {
                window.initFlatpickr = () => {
                    flatpickr('.flatpickr', {
                        dateFormat: 'd/m/Y',
                        locale: 'pt',
                        allowInput: true
                    })
                }

                Livewire.hook('message.processed', (message, component) => {
                    initFlatpickr()
                })

                initFlatpickr()
            });
        </script>
    @endscript

    @script
        <script>
            Livewire.on('preencherSelect2', dataArray => {
                const data = dataArray[0];

                if (data.equipamento_id) {
                    $('.equipamentos').empty().trigger('change');
                    let option = new Option(data.equipamento_id.text, data.equipamento_id.id, true, true);
                    $('.equipamentos').append(option).trigger('change');
                }

                if (data.tecnico_id) {
                    $('.tecnicos').empty().trigger('change');
                    let option = new Option(data.tecnico_id.text, data.tecnico_id.id, true, true);
                    $('.tecnicos').append(option).trigger('change');
                }
            });
        </script>
    @endscript

    @script
        <script>
            $(document).ready(function () {
                $('.select2-servico').select2({
                    ajax: {
                        url: '/servicos/search',
                        dataType: 'json',
                        processResults: function (data) {
                            return {
                                results: data.data,
                                pagination: {
                                    more: (params.page * 10) < data.total
                                }
                            };
                        }
                    }
                }).on('select2:select', function (e) {
                    let index = $(this).data('index');
                    let servicoId = e.params.data.id;
                    Livewire.dispatch('atualizarServicoSelecionado', { index, servicoId });
                });
            });
        </script>
    @endscript

    @script
        <script>
            $(document).ready(function () {
                $('.select2-peca').select2({
                    ajax: {
                        url: '/pecas/search',
                        dataType: 'json',
                        processResults: function (data) {
                            return {
                                results: data.map(item => ({
                                    id: item.id,
                                    text: item.descricao
                                }))
                            };
                        }
                    }
                }).on('select2:select', function (e) {
                    let index = $(this).data('index');
                    let pecaId = e.params.data.id;
                    Livewire.dispatch('atualizarPecaSelecionada', { index, pecaId });
                });
            });
        </script>
    @endscript
</div>
