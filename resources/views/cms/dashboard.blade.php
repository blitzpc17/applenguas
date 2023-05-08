@extends('cms.layout')


@section('title', 'Inicio')

@section('contenido')





<div style="width:100%; height:70vh;">

@if (session()->has('success'))
<div style="width:100%;" class="alert alert-success" role="alert">
    {{session()->get('success')}}
</div>  
@endif





</div>
 



@endsection