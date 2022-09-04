<option value="">-- Select Branch --</option>
    @foreach($group as $g)
        <option value="{{$g->id}}">{{$g->group_name}}</option>
    @endforeach