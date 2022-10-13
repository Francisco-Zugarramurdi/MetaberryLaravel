document.getElementById("add_team_local_button").addEventListener('click',()=>{
    document.getElementById("team_card_local_container").innerHTML += 
    `<div class="team-container">
    
        <label>
            Player
            <select name="player" id="player">
                @foreach($players as $player)
                <option value="{{$player->id}}">{{$player->name}}</option>
                @endforeach
            </select>
        </label>

        <label>
            Point
            <input type="number" name="point" id="point">
        </label>

    </div>`;
})

document.getElementById("add_team_visitor_button").addEventListener('click',()=>{

    document.getElementById("team_card_visitor_container").innerHTML += 
    `<div class="team-container">
    
        <label>
            Player
            <select name="player" id="player">
                @foreach($players as $player)
                <option value="{{$player->id}}">{{$player->name}}</option>
                @endforeach
            </select>
        </label>

        <label>
            Point
            <input type="number" name="point" id="point">
        </label>

    </div>`;
})