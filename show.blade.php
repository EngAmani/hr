@extends('layouts.app')

@section('title',' عرض بيانات ')

@section('content')
<?php $global_format = env("GLOBAL_DATE_FORMAT","d-m-Y"); ?>
<div class="card">
    <div class="card-body">
       <h3 style="  margin-left: 860px; float: right;">{{ $post->user->name}}</h3>
       <br><br>
       <h5 style="  margin-left: 860px; float: right;">{{ Carbon\Carbon::parse($post->time_in)->format('g:i A')}}</h5>
       <h5 style="  margin-left: 860px; float: right;">{{Carbon\Carbon::parse($post->time_out)->format('g:i A')}}</h5>
       <h5 style="  margin-left: 860px; float: right;">{{ Carbon\Carbon::parse($post->date)->format($global_format)}}</h5>  
       <h5 style="  margin-left: 860px; float: right;">{{$post->absent}}</h5>
       <h5 style="  margin-left: 860px; float: right;">{{$post->absent_type}}</h5>
       <h5 style="  margin-left: 860px; float: right;">{{$post->excuse_time}}</h5>
       <h5 style="  margin-left: 860px; float: right;">{{$post->notes}}</h5>

    </div>
</div>
@endsection