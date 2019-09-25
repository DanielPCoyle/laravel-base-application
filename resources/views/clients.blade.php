@extends('layouts.app')

@section('content')
<b-container>
  <b-tabs content-class="mt-3">
    <b-tab title="Clients" active><passport-clients></passport-clients></b-tab>
    <b-tab title="Authorized Clients"><passport-authorized-clients></passport-authorized-clients></b-tab>
    <b-tab title="Personal Access Tokens"><passport-personal-access-tokens></passport-personal-access-tokens></b-tab>
  </b-tabs>
  <b-row class='mt-5'>
  	<b-col>
  	<h1  align='center'>Authenticating the Base Client</h1>
  	<p>After creating an Oauth Client, go to your .env file in your Base-Client's root directory and add the following:</p>
  	<div>
  		<pre>
			APP_CLIENT_ID=[YOUR CLIENT ID]
			APP_CLIENT_SECRET=[YOUR CLIENT SECRET]
		</pre>
  	</div>
  	<p>Next, in your client application go to</p>
  	<pre>
		http://[YOUR CLIENT DOMAIN]/redirect
	</pre>
	<p>Login and authorize the client. After that you will be redirected to your client's call back page. Durring the process your access tokens should have been saved to a file called
	 <b>'
	appaccess.json'</b> in your client's root directory.</p>
	<p>Your base application should be ready to go now</p>
  	</b-col>
  </b-row>
</b-container>
@endsection