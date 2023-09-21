{{-- Проверка глобального массива ошибок --}}
@if(count($errors) > 0)
    @foreach ($errors->all() as $item)
        <div class="row justify-content-center mt-3">
            <div class="alert alert-danger">
                {{ $item }}
            </div>
        </div>
    @endforeach
@endif

@if(session('success'))
    <div class="row justify-content-center mt-3">
        <div class="alert alert-success mess_success">
            {{ session('success') }}
        </div>
    </div>
@endif

@if(session('error'))
    <div class="row justify-content-center mt-3">
        <div class="alert alert-danger">
            {{ $item }}
        </div>
    </div>
@endif