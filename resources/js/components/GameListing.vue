<template>
  <div class="col-6">

    <div class="row" style="border:1px solid white; padding: 6px; background-color:black;">
      <div class="col-10">
        <p>Game <i class="fas fa-hashtag"></i>{{ game.id }} {{ game.status }} Wager: {{ game.wager }} credit(s)</p>
      </div>
      <div class="col-2">
        <button class="btn btn-primary" style="width:100%;" v-on:click="JoinGame(game.id)">Join</button>
      </div>
    </div>

  </div>
</template>

<script>
export default {

    props: ['game'],

    created() {

    },

    data() {
        return {

        }
    },

    methods: {

      JoinGame (GameID) {
        axios.post('/game/join/' + GameID, {
          user_id: localStorage.UserID,
          game_id: GameID
        })
        .then((response) => {
          if (response.status == 200) {
            location.assign(response.data);
          }
        });

      }

    }
}
</script>
