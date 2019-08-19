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

                    <h3 class="text-center">Message</h3>

                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-2"><b>ID</b></div>
                                <div class="col-10">{{ $message->id }}</div>
                                <div class="col-2"><b>Nome</b></div>
                                <div class="col-10">{{ $message->name }}</div>
                                <div class="col-2"><b>Description</b></div>
                                <div class="col-10">{{ $message->description }}</div>
                                <div class="col-2"><b>Phone</b></div>
                                <div class="col-10">{{ $message->phone }}</div>
                                <div class="col-2"><b>Status</b></div>
                                <div class="col-10">{{ $message->status }}</div>
                                <div class="col-2"><b>Active</b></div>
                                <div class="col-10">{{ $message->active }}</div>
                            </div>
                            
                        </div>

                        <div class="card-footer">
                                <a href="{{ route('message.edit', $message->id) }}" class="btn btn-outline-success btn-sm ml-2">Edit</a>
                        </div>

                    </div>

                    <div class="card mt-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-2"><b>SessionID</b></div>
                                <div class="col-10">{{ $message->session_id ? $message->session_id : '-' }}</div>
                            </div>
                            
                        </div>

                        <div class="card-footer">
                                <a href="{{ route('message.start', $message->id) }}" class="btn btn-outline-success btn-sm ml-2">Start</a>
                                <a href="{{ route('message.stop', $message->id) }}" class="btn btn-outline-danger btn-sm ml-2">Stop</a>
                                <a href="{{ route('message.clear', $message->id) }}" class="btn btn-outline-info btn-sm ml-2">Clear</a>
                        </div>
                        
                    </div>

                    <div class="card mt-4">
                            <div class="card-body">
                                    <form action="{{ route('message.send', $message->id) }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            @php( $field = 'phone' )
                                            <label for="{{ $field }}">Phone</label>
                                            <input type="text" class="form-control @error($field) is-invalid @enderror" value="{{ old( $field ) }}" id="{{ $field }}" name="{{ $field }}" placeholder="5500000000000">
                                        </div>
                                        <div class="form-group">
                                            @php( $field = 'message' )
                                            <label for="exampleFormControlTextarea1">Message</label>
                                            <textarea class="form-control @error($field) is-invalid @enderror" value="{{ old( $field ) }}" id="{{ $field }}" name="{{ $field }}" rows="4"></textarea>
                                        </div>
                                        <button type="reset" class="btn btn-info bg-white">Clear</button>
                                        <input type="submit" class="btn btn-success" value="Send">
                                    </form>                               
                            </div>
    
                            <div class="card-footer">
                                <a href="{{ route('message.createwhatsapp', $message->id) }}" class="btn btn-outline-success btn-sm ml-2">Start Whatsapp</a>
                            </div>
                            
                        </div>
                
        </div>
            
    </div>
    </div>
</div>
@endsection
