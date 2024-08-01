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
        <h1 class="page-title">Título Principal Customer</h1>
        <div class="customer-info">
            <div class="customer-details">
                <p><strong>ID:</strong> {{ $customer->id }}</p>
                <div class="customer-image">
                    <img src="{{ asset($customer->image) }}" alt="Customer Image" class="img-thumbnail">
                </div>
                <p><strong>Name:</strong> {{ $customer->name }}</p>
                <p><strong>Active:</strong> {{ $customer->active == '1' ? 'Yes' : 'No' }}</p>
                <p><strong>Email:</strong> {{ $customer->email }}</p>
                <p><strong>Whatsapp:</strong> {{ $customer->whatsapp }}</p>
            </div>
        </div>

        {{-- <div class="timeline-info">
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

            {{ $timelines->links() }} --}}
    </div>
    </div>
@endsection

<style scoped>
    /* General Styles */
    .home {
        padding: 20px;
    }

    .page-title {
        font-size: 2rem;
        margin-bottom: 20px;
        color: #333;
    }

    /* Customer Info Section */
    .customer-info {
        margin-bottom: 40px;
    }

    .section-title {
        font-size: 1.5rem;
        margin-bottom: 15px;
        color: #555;
    }

    .customer-details p {
        font-size: 1rem;
        margin: 5px 0;
    }

    .customer-image img {
        border-radius: 8px;
        border: 1px solid #ddd;
    }

    /* Timeline Table */
    .table {
        width: 100%;
        margin-bottom: 20px;
        border-collapse: collapse;
    }

    .table thead th {
        background-color: #f8f9fa;
        color: #333;
        padding: 10px;
    }

    .table tbody td {
        padding: 10px;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f9f9f9;
    }

    .table-bordered {
        border: 1px solid #ddd;
    }

    .img-thumbnail {
        border-radius: 4px;
        max-width: 100px;
        max-height: 100px;
    }

    .audio-player {
        width: 100%;
    }

    
</style>
