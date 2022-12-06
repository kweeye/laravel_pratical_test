@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Form</div>
                <form action="{{route('form_render_store')}}" method="POST" accept-charset="UTF-8">
                {!! csrf_field() !!}
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        @foreach($form_render as $form)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" name="form_fields[]" type="checkbox" id="{{$form->id}}" value="{{$form->id}}"
                                @if($form->status == 1) checked @endif>
                                <label class="form-check-label" for="{{$form->id}}">{{$form->label}}</label>
                            </div>
                        @endforeach
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success" @click="submitAccount"><i class="fas fa-save"></i> Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
