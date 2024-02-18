@if(session('success'))
    <div class="alert alert-success">{{session('success')}}</div>
@endif

@if(session('error'))
    <div class="alert alert-danger">{{session('error')}}</div>
@endif

@foreach ($errors->getBags() as $errorBag)
    @if($errorBag->any())
        <div class="alert alert-danger">
            {{ implode(' ', $errorBag->all()) }}
        </div>
    @endif
@endforeach
