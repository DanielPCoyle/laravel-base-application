@extends('layouts.app')

@section('content')
<b-container>
	<h1>{{ucfirst($entity)}}</h1>
	<h4>Example Form:</h4>
	<fields :fields="{{json_encode($fields)}}"  :values="{}"></fields>
	<b-button variant='primary'>Check Validation</b-button>
</b-container>
@endsection