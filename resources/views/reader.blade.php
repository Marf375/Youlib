@extends('layouts.app')

@section('content')
    <div class="container bg-black">
        <h2>Просмотр файла: {{ $filename }}</h2>
        <iframe src="{{ route('pdf.view', ['filename' => $filename]) }}" width="100%" height="800px " class="bg-[#000000]"></iframe>
    </div>
@endsection

