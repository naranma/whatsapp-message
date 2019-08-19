@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h3 class="text-center">Session Whatsapp</h3>

                    <div class="card">
                        <div class="card-body">
                            @if($image)
                                <div class="text-center">
                                    <img src="{{$image}}" alt="QRCode">                           
                                </div>
                            @endif
                        </div>

                        <div class="card-footer">
                                <a href="{{ route('message.show', $message->id) }}" class="btn btn-outline-success btn-sm ml-2">Reload</a>
                                <a href="{{ route('message.qrcode', $message->id) }}" class="btn btn-outline-success btn-sm ml-2">Refresh</a>
                                <a href="{{ route('message.show', $message->id) }}" class="btn btn-outline-info btn-sm ml-2">Back</a>
                        </div>

                    </div>
                
        </div>
            
    </div>
    </div>
</div>
@endsection
