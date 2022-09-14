<option value="">-- Select Company --</option>
    @foreach($company as $c)
        <option value="{{$c->id}}">{{$c->company_name}}</option>
    @endforeach