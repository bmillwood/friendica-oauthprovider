<h4>Add new app</h4>
<table class="oauthprovider-app">
    <tr><th>{{$head_name}}</th><td><input type="text" name="name"></td></tr>
    <tr><th>{{$head_website}}</th><td><input type="text" name="website" placeholder="{{$optional}}"></td></tr>
    <tr><th>{{$head_redirect_uri}}</th><td><input type="text" name="redirect_uri"></td></tr>
    <tr><th>{{$head_scopes}}</th><td>
        <ul>
            <li><label for="scope_read"><input id="scope_read" type="checkbox" name="read" checked="checked"> Read</label></li>
            <li><label for="scope_write"><input id="scope_write" type="checkbox" name="write"> Write</label></li>
            <li><label for="scope_follow"><input id="scope_follow" type="checkbox" name="follow"> Follow</label></li>
            <li><label for="scope_push"><input id="scope_push" type="checkbox" name="push"> Push</label></li>
        </ul>
    </td></tr>
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
