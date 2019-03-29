<template>
  <transition appear enter-active-class="animated bounceInRight" leave-active-class="animated bounceOutLeft" v-on:after-leave="ShowMenu(this.MenuName)">
    <div class="container" v-show="showGameList">
      <h1>open Games</h1>
      <h4 style="cursor: pointer;" v-on:click="CloseMenu('Versus')"><i class="fas fa-angle-left"></i> Back</h4>
      <div class="row">
        <game-listing v-for="(game, index) in openGames" v-bind:game="game" v-bind:index="index" v-bind:key="game.id"></game-listing>
      </div>
    </div>
  </transition>
</template>

<script>

export default {

  data() {
    return {
      openGames: [],
      showGameList: false
    }
  },

  created() {
    this.GetAllOpenGames()

    window.Echo.channel('games').listen('NewGameCreated', e => {
      this.openGames.push(e.game)
    });

    window.Echo.channel('games').listen('GameIsFull', e => {
      console.log(e)
    });

    this.$eventHub.$on('OpenGameList', this.ShowGameList);

      this.$eventHub.$on('MenuClicked', (data) => {
        if(data == "GameList"){
          this.showGameList = true
        }
      });

  },

  methods: {

    ShowMenu() {
      this.$eventHub.$emit('MenuClicked', this.NewMenu)
    },

    CloseMenu(MenuName) {
      this.NewMenu = MenuName
      this.showGameList = false
    },

    ShowGameList() {
      this.showGameList = true
    },

    GetAllOpenGames() {
      axios.get('/games/all').then(response => (this.openGames = response.data))
    }

  }

}
</script>
