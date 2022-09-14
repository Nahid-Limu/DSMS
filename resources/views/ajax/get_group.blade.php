<option value="">-- Select Group --</option>
    @foreach($group as $g)
        <option value="{{$g->id}}">{{$g->group_name}}</option>
    @endforeach