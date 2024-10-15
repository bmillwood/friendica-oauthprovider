<h4>Add new app</h4>
<table class="oauthprovider-app">
    <tr><th>{{$head_name}}</th><td><input type="text" name="name"></td></tr>
    <tr><th>{{$head_website}}</th><td><input type="text" name="website" placeholder="{{$optional}}"></td></tr>
    <tr><th>{{$head_redirect_uri}}</th><td><input type="text" name="redirect_uri"></td></tr>
    <tr><th>{{$head_scopes}}</th><td><input type="text" name="scopes"></td></tr>
</table>
<button type="submit">{{$submit}}</button></td>

<h4>Existing apps</h4>
{{foreach $apps as $a}}
    <h5>{{$a.name}}</h5>
    <button type="submit" name="delete" value="{{$a.name}}">Delete</button>
    <table class="oauthprovider-app">
        <tr><th>{{$head_website}}</th><td>{{$a.website}}</td></tr>
        <tr><th>{{$head_redirect_uri}}</th><td>{{$a.redirect_uri}}</td></tr>
        <tr><th>{{$head_scopes}}</th><td>{{$a.scopes}}</td></tr>
        <tr><th>{{$head_client_id}}</th><td>{{$a.client_id}}</td></tr>
        <tr><th>{{$head_client_secret}}</th><td>{{$a.client_secret}}</td></tr>
    </table>
    {{/foreach}}
