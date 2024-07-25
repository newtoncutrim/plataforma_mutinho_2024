@extends('cms.layouts.page')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <ui-form form-class="form-horizontal" title="Atualizar Registro" token="{{ csrf_token() }}"
                url="{{ route('clients.timeline.update', [$item->client_id, $item->id]) }}"
                cancel-url="{{ route('clients.timeline.index', [$item->client_id]) }}" method="PUT">
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
                            {{ $item->active ? ($item->active ? 'checked' : '') : 'checked' }}> Ativo
                        @if ($errors->has('active'))
                            <span class="help-block">
                                <strong>{{ $errors->first('active') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="row form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                    <label for="title"
                        class="col-xl-2 col-lg-2 col-sm-2 col-12 text-lg-right text-sm-left">Titulo*</label>
                    <div class="col-xl-10 col-lg-10 col-sm-10 col-12">
                        <input class="form-control" aria-label="Nome" type="text" required name="title" id="title"
                            value="{{ $item->title }}">
                        @if ($errors->has('title'))
                            <span class="help-block">
                                <strong>{{ $errors->first('title') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="row form-group{{ $errors->has('lead') ? ' has-error' : '' }}">
                    <label for="lead" class="col-xl-2 col-lg-2 col-sm-2 col-12 text-lg-right text-sm-left">Sub
                        Titulo</label>
                    <div class="col-xl-10 col-lg-10 col-sm-10 col-12">
                        <input class="form-control" aria-label="Nome" type="text" required name="lead" id="lead"
                            value="{{ $item->lead }}">
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
                                <input placeholder="Data e Hora" class="mouse-alter datepicker mb-md-0 mb-2 form-control"
                                    value="{{ $item->date }}" name="date" id="inputDate">
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
                    <label for="description"
                        class="col-xl-2 col-lg-2 col-sm-2 col-12 text-lg-right text-sm-left">Descrição*</label>
                    <div class="col-xl-10 col-lg-10 col-sm-10 col-12">
                        <ui-textarea url="{{ route('upload-images') }}" name="description" id="full_textarea"
                            value="{{ $item->description }}">
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
                    <div class="col-sm-10">
                        <div class="row">
                            @if (strlen($item->image) > 0)
                                <div class="col-md-2 col-xs-4">
                                    <img src="{{ asset($item->image) }}" style="width:100%">
                                </div>
                            @endif
                            <div class="col-xl-10 col-lg-10 col-sm-10 col-12">
                                <input type="file" name="image">
                                <input type="hidden" aria-label="Nome" aria-label="Nome" name="old-image"
                                    value="{{ $item->image }}">
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
                <div class="row form-group{{ $errors->has('audio') ? ' has-error' : '' }}">
                    <label class="col-xl-2 col-lg-2 col-sm-2 col-12 text-lg-right text-sm-left">Áudio*</label>
                    <div class="col-xl-10 col-lg-10 col-sm-10 col-12">
                        <input type="file" accept="audio/*" name="audio" id="audio">
                        @if ($errors->has('audio'))
                            <span class="help-block">
                                <strong>{{ $errors->first('audio') }}</strong>
                            </span>
                        @endif
                
                        @if (strlen($item->audio) > 0)
                            <div class="current-audio">
                                <p class="audio-title">Áudio atual:</p>
                                <audio class="audio" controls>
                                    <source src="{{ asset($item->audio) }}"
                                        type="audio/{{ pathinfo($item->audio, PATHINFO_EXTENSION) }}">
                                    Seu navegador não suporta o elemento de áudio.
                                </audio>
                                <input type="hidden" name="old-audio" value="{{ $item->audio }}">
                                <span class="help-block">
                                    Para manter o áudio atual, não preencha esse campo.
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
            </ui-form>
        </div>
    </div>
    </div>
@endsection
