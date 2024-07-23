@extends('cms.layouts.page')

@section('content')
<div class="row">
    <div class="col-md-12">
        <tabs :tabs="[
                    {'icon' : 'fa fa-list', 'title' : 'Lista de Registros', 'active' : false},
                    { 'icon': 'fa fa-plus', 'title': 'Cadastro de Registros', 'active': false },
                ]" active-tab="0">
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
                <ui-form form-class="form-horizontal" title="Adicionar Registro" token="{{ csrf_token() }}" url="{{ route('clients.informations.store', $clients->id) }}" cancel-url="{{ route('clients.informations.index', $clients->id) }}" method="POST">

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
                    @if ($errors->any())
                            <div class="row">
                                <div class="col-sm-12">
                                    <alert class="alert-danger" icon="fa-ban" title="Ops!"
                                        text="Não foi possível adicionar o registro, verifique os campos em destaque!">
                                    </alert>
                                </div>
                            </div>
                    @endif
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
