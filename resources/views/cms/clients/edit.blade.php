@extends('cms.layouts.page')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <ui-form form-class="form-horizontal" title="Atualizar Registro" token="{{ csrf_token() }}"
                url="{{ route('clients.update', $clients->id) }}" cancel-url="{{ route('clients.index') }}" method="PUT">
                @if ($errors->any())
                    <div class="col-sm-12">
                        <alert class="alert-danger" icon="fa-ban" title="Ops!"
                            text="Não foi possível atualizar o registro, verifique os campos em destaque!">
                        </alert>
                    </div>
                @endif

                <div class="row form-group{{ $errors->has('active') ? ' has-error' : '' }}">
                    <label class="col-xl-2 col-lg-2 col-sm-2 col-12 text-lg-right text-sm-left">Status</label>
                    <div class="col-xl-10 col-lg-10 col-sm-10 col-12">
                        <input type="checkbox" aria-label="Nome" name="active" id="active" value="1"
                            {{ $clients->active == '1' ? 'checked' : '' }}> Ativo
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
                                <ui-cpf required class_name="form-control" name="cpf" value="{{ $clients->cpf }}"
                                    :error="{{ json_encode($errors->first('cpf')) }}">
                                </ui-cpf>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6{{ $errors->has('email') ? ' has-error' : '' }}">
                        <div class="row">
                            <label class="col-sm-4 control-label" for="email">Email*</label>
                            <div class="col-sm-8">
                                <input required class="form-control" id="email" minlength="0" name="email"
                                    type="email" value="{{ $clients->email }}">
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
                                    type="text" value="{{ $clients->name }}">
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
                                    type="text" value="{{ $clients->whatsapp }}">
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
                <div class="form-group row">
                    <div class="col-sm-6{{ $errors->has('password') ? ' has-error' : '' }}">
                        <div class="row">
                            <label class="col-sm-4 control-label" for="password">Senha*</label>
                            <div class="col-sm-8">
                                <input required class="form-control" id="password" minlength="0" name="password"
                                    type="text" value="{{ $clients->password }}">
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
                
                <div class="row form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                    <label class="col-xl-2 col-lg-2 col-sm-2 col-12 text-lg-right text-sm-left">Imagem*</label>
                    <div class="col-sm-10">
                        <div class="row">
                            @if (strlen($clients->image) > 0)
                                <div class="col-md-2 col-xs-4">
                                    <img src="{{ asset($clients->image) }}" style="width:100%">
                                </div>
                            @endif
                            <div class="col-xl-10 col-lg-10 col-sm-10 col-12">
                                <input type="file" name="image">
                                <input type="hidden" aria-label="Nome" aria-label="Nome" name="old-image"
                                    value="{{ $clients->image }}">
                                <span class="help-block">
                                    Para manter a imagem atual, não preencha esse campo
                                </span>
                                @if ($errors->has('image'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('image') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <span class="help-block">
                            Tamanho e formato recomendado: 800x450px JPG
                        </span>
                    </div>
                </div>
                {{--             <div class="row form-group">
                @foreach ($inputs as $key => $item)
                <label class="col-xl-1 col-lg-1 col-sm-1 col-12 text-lg-right text-sm-left">{{$key}}</label>
                <div class="col-xl-5 col-lg-5 col-sm-5 col-12">
                    <input type="text" class="form-control" aria-label="{{$key}}" disabled value="{{$item}}">
                </div>
                @endforeach
            </div> --}}
        </div>
        </ui-form>
    </div>
    </div>
@endsection
