@extends('front.layouts.page')

@section('content')

    <div class="home">
        <h1 class="page-title">Título Principal Customer</h1>
        <div class="customer-info">
            <div class="customer-details">
                <p><strong>ID:</strong> {{$customer->id}}</p>
                <div class="customer-image">
                    <img src="{{ asset($customer->image) }}" alt="Customer Image" class="img-thumbnail">
                </div>
                <p><strong>Name:</strong> {{$customer->name}}</p>
                <p><strong>Active:</strong> {{$customer->active == '1' ? 'Yes' : 'No'}}</p>
                <p><strong>Email:</strong> {{$customer->email}}</p>
                <p><strong>Whatsapp:</strong> {{$customer->whatsapp}}</p>
            </div>
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