@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if(isset($error))

                    @else
                        Der Folgende QR-Code wurde gefunden: <b>{{ $checkExists[0]->game_code }}</b><br/>
                        Dieser bringt dir <b>{{ $checkExists[0]->points }}</b> Punkte ein.<br/>
                        <b>Gut gemacht. Such weiter.</b>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
