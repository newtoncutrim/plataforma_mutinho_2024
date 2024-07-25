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


            </ui-form>
        </div>
    </div>
    </div>
@endsection
