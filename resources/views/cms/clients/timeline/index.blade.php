@extends('cms.layouts.page')

@section('content')
<div class="row">
    <div class="col-md-12">
        <tabs :tabs="[
                    {'icon' : 'fa fa-list', 'title' : 'Lista de Registros', 'active' : false},
                    { 'icon': 'fa fa-plus', 'title': 'Cadastro de Registros', 'active': false },
                ]" active-tab="{{$errors->any() ? 1 : 0}}">
            <data-table-clients slot="tabslot_0" title="Lista de Registros" busca="{{$busca}}" url="{{ $data['request']->url() }}" token="{{ csrf_token() }}" :items="{{ json_encode($items) }}" :titles="{{$titles}}" :actions="{{ $actions }}" :not-deletable="false" :show-busca="true" urlsistem="{{ url('/') }}">
                @if(session()->has('message'))
                <div class="row">
                    <div class="col-sm-12">
                        <alert class="alert-success" icon="fa-check" text="{{ session()->get('message') }}">
                        </alert>
                    </div>
                </div>
                @endif
                <span slot="pagination" class="pull-right">
                    {{ $items->links() }}
                </span>
            </data-table-clients>
            <div slot="tabslot_1">
                <ui-form form-class="form-horizontal" title="Adicionar Registro" token="{{ csrf_token() }}" url="{{ route('clients.timeline.store', $clients->id) }}" cancel-url="{{ route('clients.timeline.index', $clients->id) }}" method="POST">

                    @if ($errors->any())
                            <div class="row">
                                <div class="col-sm-12">
                                    <alert class="alert-danger" icon="fa-ban" title="Ops!"
                                        text="Não foi possível adicionar o registro, verifique os campos em destaque!">
                                    </alert>
                                </div>
                            </div>
                    @endif
                    <div class="row form-group{{ $errors->has('active') ? ' has-error' : '' }}">
                        <label class="col-xl-2 col-lg-2 col-sm-2 col-12 text-lg-right text-sm-left">Status</label>
                        <div class="col-xl-10 col-lg-10 col-sm-10 col-12">
                            <input type="checkbox" aria-label="Nome" name="active" id="active" value="1"
                                {{ old('active') ? (old('active') ? 'checked' : '') : 'checked' }}> Ativo
                            @if ($errors->has('active'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('active') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="row form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                        <label for="title" class="col-xl-2 col-lg-2 col-sm-2 col-12 text-lg-right text-sm-left">Titulo*</label>
                        <div class="col-xl-10 col-lg-10 col-sm-10 col-12">
                            <input class="form-control" aria-label="Nome" type="text" required name="title" id="title" value="{{ old('title') }}">
                            @if ($errors->has('title'))
                            <span class="help-block">
                                <strong>{{ $errors->first('title') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="row form-group{{ $errors->has('lead') ? ' has-error' : '' }}">
                        <label for="lead" class="col-xl-2 col-lg-2 col-sm-2 col-12 text-lg-right text-sm-left">Sub Titulo</label>
                        <div class="col-xl-10 col-lg-10 col-sm-10 col-12">
                            <input class="form-control" aria-label="Nome" type="text" required name="lead" id="lead" value="{{ old('lead') }}">
                            @if ($errors->has('lead'))
                            <span class="help-block">
                                <strong>{{ $errors->first('lead') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
						<div>
							<div class="row form-group{{ $errors->has('date') ? ' has-error' : '' }}">
								<label class="col-xl-2 col-lg-2 col-sm-2 col-12 text-lg-right text-sm-left">Data</label>
								<div class="col-xl-10 col-lg-10 col-sm-10 col-12">
									<input placeholder="Data e Hora" class="mouse-alter datepicker mb-md-0 mb-2 form-control" value="{{ old('date') }}" name="date" id="inputDate">
									@if ($errors->has('date'))
									<span class="help-block">
										<strong>{{ $errors->first('date') }}</strong>
									</span>
									@endif
								</div>
							</div>
						</div>
					</div>
                    <div class="row form-group {{ $errors->has('description') ? ' has-error' : '' }}">
                        <label for="description" class="col-xl-2 col-lg-2 col-sm-2 col-12 text-lg-right text-sm-left">Descrição*</label>
                        <div class="col-xl-10 col-lg-10 col-sm-10 col-12">
                            <ui-textarea url="{{ route('upload-images') }}" name="description" id="full_textarea" value="{{ old('description') }}">
                            </ui-textarea>
                            @if ($errors->has('description'))
                            <span class="help-block">
                                <strong>{{ $errors->first('description') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="row form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                        <label class="col-xl-2 col-lg-2 col-sm-2 col-12 text-lg-right text-sm-left">Imagem*</label>
                        <div class="col-xl-10 col-lg-10 col-sm-10 col-12">
                            <input type="file" aria-label="Nome" name="image" id="image" required>
                            @if ($errors->has('image'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('image') }}</strong>
                                </span>
                            @endif
                            <span class="help-block">
                                Tamanho e formato recomendado: 800x450px JPG
                            </span>


                        </div>
                    </div>
                    <div class="row form-group{{ $errors->has('audio') ? ' has-error' : '' }}">
                        <label class="col-xl-2 col-lg-2 col-sm-2 col-12 text-lg-right text-sm-left">Audio*</label>
                        <div class="col-xl-10 col-lg-10 col-sm-10 col-12">
                            <input type="file" aria-label="Nome" accept="audio/*" name="audio" id="audio" required>
                            @if ($errors->has('audio'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('audio') }}</strong>
                                </span>
                            @endif

                        </div>
                    </div>
                </ui-form>
            </div>
        </tabs>
    </div>
    <script>
        $(document).ready(function() {
            $("#whatsapp").mask('(00) 00000-0000');
            $("#cpf").mask('000.000.000-00');
        });
    </script>
</div>
@endsection
