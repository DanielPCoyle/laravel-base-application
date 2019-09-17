@extends('layouts.app')

@section('content')
<b-container>
  <b-tabs content-class="mt-3">
    <b-tab title="Clients" active><passport-clients></passport-clients></b-tab>
    <b-tab title="Authorized Clients"><passport-authorized-clients></passport-authorized-clients></b-tab>
    <b-tab title="Personal Access Tokens"><passport-personal-access-tokens></passport-personal-access-tokens></b-tab>
  </b-tabs>
</b-container>
@endsection