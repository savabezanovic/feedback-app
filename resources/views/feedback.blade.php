@extends('layouts.master')
@section('content')
<div class="admin">   
    <h2>Admin panel</h2>

    <div id="tabs">
        <ul class="inline-flex tabs">
            <li class="tab"><a href="#tabs-1">Users</a></li>
            <li class="tab"><a href="#tabs-2">Skills list</a></li>
            <li class="tab"><a href="#tabs-3">Teams list</a></li>
            <li class="tab"><a href="#tabs-4">Positions</a></li>
        </ul>
        <div id="tabs-1" class="tab-view">
            <input type="email" placeholder="User e-mail">
            <input type="text" placeholder="User password">
            <select>
                <option>FE</option>
                <option>BE</option>
            </select>
            <select>
                <option>Team BG</option>
                <option>Team NS</option>
                <option>Team CA</option>
                <option>Team NI</option>
            </select>
            <button class="admin-btn">Add user</button>
            <table>
                <tr>
                    <th>Name</th>
                    <th>Password</th>
                    <th>Team</th>
                    <th>Position</th>
                </tr>
                <tr>
                    <td>John Doe</td>
                    <td>bestPassword123</td>
                    <td>BG</td>
                    <td>Cleaner</td>
                </tr>
            </table>

        </div>
        <div id="tabs-2" class="tab-view">
            <input placeholder="Add skill">
            <button class="admin-btn">Add skill</button>
            <li>skill</li>
            <li>skill</li>
            <li>skill</li>
            <li>skill</li>
            <li>skill</li>
            <li>skill</li>
            <li>skill</li>
            <li>skill</li>
        </div>
        <div id="tabs-3" class="tab-view">
            <input placeholder="New team name">
            <button class="admin-btn">Add team</button>
            <li>Team1</li>
            <li>Team2</li>
            <li>Team3</li>
            <li>Team4</li>
            <li>Team5</li>
            <li>Team6</li>
        </div>
        <div id="tabs-4" class="tab-view">
            <input placeholder="Add position">
            <button class="admin-btn">Add position</button>
            <li>Position1</li>
            <li>Position2</li>
            <li>Position3</li>
        </div>

    
    </div>






</div>
{{-- <div>
@forelse($skills as $skill)
    <span class="single-skill">
        {{$skill->name}}
    </span>
    @empty
        <p>Currently no skills.</p>
@endforelse
</div> --}}

@endsection
@section('script')
<script>
    $( function() {
        $( "#tabs" ).tabs();
    } );
</script>
@endsection