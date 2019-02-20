<template>
<div class="container">
  <h1>open Games</h1>
  <div class="row">
    <game-listing v-for="(game, index) in openGames" v-bind:game="game" v-bind:index="index" v-bind:key="game.id"></game-listing>
  </div>
</div>
</template>

<script>
export default {
    created() {
      this.GetAllOpenGames()

      window.Echo.channel('games').listen('NewGameCreated', e => {
        this.openGames.push(e.game);
      });

    },

    data() {
        return {
            openGames: [],
        }
    },

    methods: {

      GetAllOpenGames() {
        axios.get('/games/all').then(response => (this.openGames = response.data))
      }

    }
}
</script>
