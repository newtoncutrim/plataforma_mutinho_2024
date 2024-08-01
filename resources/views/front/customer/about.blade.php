@extends('front.layouts.page')

@section('content')

    <div class="home">

        <div class="men">
            <ul>
                <li><a href="{{ asset("/timeline?id={$customer->id}") }}">Sobre o Cliente</a></li>
                <li><a href="">Estrategia Geral</a></li>
                <li><a href="">Identidade Visual</a></li>
                <li><a href="">Planejamentos</a></li>
                <li><a href="">Resultados</a></li>
            </ul>
        </div>
        <div class="timeline-info">
            <h2 class="section-title">Timeline Data:</h2>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Lead</th>
                        <th>Date</th>
                        <th>Image</th>
                        <th>Audio</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($timelines as $timeline)
                        <tr>
                            <td>{{ $timeline->title }}</td>
                            <td>{{ $timeline->lead }}</td>
                            <td>{{ $timeline->date }}</td>
                            <td>
                                <img src="{{ asset($timeline->image) }}" alt="{{ $timeline->title }}" class="img-thumbnail">
                            </td>
                            <td>
                                @if ($timeline->audio)
                                    <audio controls class="audio-player">
                                        <source src="{{ asset($timeline->audio) }}" type="audio/mpeg">
                                        Your browser does not support the audio element.
                                    </audio>
                                @endif
                            </td>
                            <td>{!! $timeline->description !!}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $timelines->links() }}
        </div>
    </div>
@endsection