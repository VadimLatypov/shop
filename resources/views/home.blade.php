@extends('layout.main')

@section('page-title')
{{ $title }}
@endsection

@section('basket-count')
{{ $basket_count }}
@endsection

@section('content')
    <h1 class="mt-5">Кабинет пользователя</h1>
    {{-- Сообщения из сессии --}}
    @if (session('status'))
        <div class="row justify-content-center">
            <div class="alert alert-success col-md-8">
                {{ session('status') }}
            </div>
        </div>
    @endif
    <p>Привет, {{ auth()->user()->name }}</p>
    <p>{{ auth()->user()->email }}</p>
    
    {{-- Форма для выхода из учетной записи --}}
    <form action="/logout" method="POST" class="d-inline-block">
        @csrf
        <button type="submit" class="btn btn-outline-danger">Выйти</button>
    </form>
@endsection
