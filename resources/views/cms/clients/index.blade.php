@extends('cms.layouts.page')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <tabs
                :tabs="[
                    { 'icon': 'fa fa-list', 'title': 'Lista de Registros', 'active': false },
                    { 'icon': 'fa fa-plus', 'title': 'Cadastro de Registros', 'active': false },
                ]" active-tab="{{$errors->any() ? 1 : 0}}"
                active-tab="0">
                <data-table-clients slot="tabslot_0" title="Lista de Registros" busca="{{ $busca }}"
                    url="{{ $data['request']->url() }}" token="{{ csrf_token() }}" :items="{{ json_encode($items) }}"
                    :titles="{{ $titles }}" :actions="{{ $actions }}" :not-deletable="false"
                    :show-busca="true" urlsistem="{{ url('/') }}">
                    @if (session()->has('message'))
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
                    <ui-form form-class="form-horizontal" title="Adicionar Registro" token="{{ csrf_token() }}"
                        url="{{ route('clients.store') }}"  method="POST">
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
                        <div class="form-group row">
                            <div class="col-sm-6{{ $errors->has('cpf') ? ' has-error' : '' }}">
                                <div class="row">
                                    <label class="col-sm-4 control-label" for="cpf">CPF*</label>
                                    <div class="col-sm-8">
                                        <ui-cpf required class="form-control" id="cpf" minlength="0" name="cpf"
                                            type="text" value="{{ old('cpf') }}">
                                        @if ($errors->has('cpf'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('cpf') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6{{ $errors->has('email') ? ' has-error' : '' }}">
                                <div class="row">
                                    <label class="col-sm-4 control-label" for="email">Email*</label>
                                    <div class="col-sm-8">
                                        <input required class="form-control" id="email" minlength="0" name="email"
                                            type="email" value="{{ old('email') }}">
                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6{{ $errors->has('name') ? ' has-error' : '' }}">
                                <div class="row">
                                    <label class="col-sm-4 control-label" for="name">Nome*</label>
                                    <div class="col-sm-8">
                                        <input required class="form-control" id="name" minlength="0" name="name"
                                            type="text" value="{{ old('name') }}">
                                        @if ($errors->has('name'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6{{ $errors->has('whatsapp') ? ' has-error' : '' }}">
                                <div class="row">
                                    <label class="col-sm-4 control-label" for="whatsapp">WhatsApp*</label>
                                    <div class="col-sm-8">
                                        <ui-phone required class="form-control" id="whatsapp" minlength="0" name="whatsapp"
                                            type="text" value="{{ old('whatsapp') }}">
                                        @if ($errors->has('whatsapp'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('whatsapp') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Comentário temporário para campos não utilizados
                    <div class="row form-group visible2 adendo-field{{ $errors->has('description') ? ' has-error' : '' }}">
                        <label for="description" class="col-xl-2 col-lg-2 col-sm-2 col-12 text-lg-right text-sm-left">Descrição*</label>
                        <div class="col-xl-10 col-lg-10 col-sm-10 col-12">
                            <ui-textarea url="{{ route('upload-images') }}" name="description_adendo" id="full_textarea" value="{{ old('description') }}">
                            </ui-textarea>
                            @if ($errors->has('description'))
                            <span class="help-block">
                                <strong>{{ $errors->first('description') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    --}}
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
                                <img id="preview" src="" alt="Pré-visualização da imagem" style="max-width: 200px; display: none;">

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

                $('#image').change(function() {
                    let image = this.files[0];
                    if (image) {
                        let img = document.getElementById('preview');
                        img.src = URL.createObjectURL(image);
                        img.style.display = 'block';
                    }
                });
            });

            
        </script>
    </div>
@endsection
