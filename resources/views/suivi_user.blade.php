@extends("navigation")
@section('title', 'Suivi des tickets')
@section("section")
<div class="container-fluid">

    <!-- Gestion des Tickets -->
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="fw-semibold">Suivi de mes tickets</h5>
                
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Exemple de Ticket -->
                @foreach($liste as $ticket)
                <div class="col-md-4">
                    <div class="card" style="height:450px">
                        <div class="card-header bg-danger text-white">
                            {{$ticket->categorie}} - (#{{ $ticket->id }})
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{$ticket->titre}}</h5>
                            <p><span class="fw-bold">Technicien traitant:</span> {{$ticket->technicien}}</p>
                            <p><span class="fw-bold">Description :</span> {{$ticket->description}}</p>
                            <p><span class="fw-bold">Priorité :</span> {{$ticket->priorite}}</p>
                            <p><span class="fw-bold">Deadline :</span> {{ \Carbon\Carbon::parse($ticket->date_deadline)->format('d/m/Y à H:i\h') }}</p>
                            <p><span class="fw-bold">Dernière mise à jour :</span> {{ \Carbon\Carbon::parse($ticket->date_resolution)->format('d/m/Y à H:i\h') }}</p>
                            @if(is_numeric($ticket->etat))
                                <p><span class="fw-bold">Évolution :</span></p>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: {{ $ticket->etat }}%" aria-valuenow="{{ $ticket->etat }}" aria-valuemin="0" aria-valuemax="100">
                                        {{ $ticket->etat }}%
                                    </div>
                                </div>
                            @else
                                <p><span class="fw-bold">Etat de traitement : {{ $ticket->etat }}</span></p>
                            @endif

                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

</div>

@endsection
