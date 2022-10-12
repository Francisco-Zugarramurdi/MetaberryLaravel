document.getElementById("add_team_button").addEventListener('click',()=>{
    document.getElementById("team_card_container").innerHTML += 
    `<div class="team-container">
    
        <label>
            Player
            <select name="player" id="player">
                @foreach($players as $player)
                <option value="({$player->id})">({$player->name})</option>
                @endforeach
            </select>
        </label>

        <label>
            Point
            <input type="number" name="point" id="point">
        </label>

    </div>`;
})

