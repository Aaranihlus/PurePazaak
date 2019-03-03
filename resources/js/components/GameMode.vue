<template>

  <div class="container">

    <transition appear enter-active-class="animated bounceInRight" leave-active-class="animated bounceOutLeft" v-on:after-leave="">
      <div class="row" style="margin-top:25vh;" v-show="showGameModes">
        <div class="col-5 game-mode-panel">
          <i class="fas fa-user fa-5x"></i>
          <h2>Practice</h2>
          <p>Play a practice game against the computer</p>
        </div>
        <div class="col-2"></div>
        <div class="col-5 game-mode-panel interactive" v-on:click="ShowVersus()">
          <i class="fas fa-users fa-5x"></i>
          <h3>versus</h3>
          <p>Go head-to-head with other players</p>
        </div>
      </div>
    </transition>

  </div>

</template>

<script>
export default {

  data() {
    return {
      showGameModes: false,
      versusChosen: false,
      createGameActive: false,
      gameWager: 0
    }
  },

  created() {
    this.$eventHub.$on('NoProfileFound', this.ChooseGameMode)
    this.$eventHub.$on('showDeckBuilder', this.HideBoth);
    this.$eventHub.$on('BuilderClosed', this.BackToGameModes);
    this.$eventHub.$on('ProfileFound', this.BackToGameModes);
    this.$eventHub.$on('ProfileCreated', this.BackToGameModes);
  },

  methods: {

    ShowVersus () {
      this.showGameModes = false
      this.$eventHub.$emit('VersusChosen');
    },

    ChooseGameMode() {
      this.showGameModes = false
    },

    ShowGameModes() {
      this.showGameModes = true
    },

    CreateNewGame() {
      axios.post('/game', {
        Wager: this.gameWager,
        UserID: localStorage.UserID
      })
      .then(function(response) {
        console.log(response)
        if (response.status == 200) {
          location.assign(response.data);
        }
      })
      .catch(function(error) {
        console.log(error);
      });
    },

    CancelCreateGame() {
      this.createGameActive = false;
    },

    OpenCreateGame() {
      this.createGameActive = true;
    },

    ClickVersus() {
      this.showGameModes = false
    },

    BackToGameModes() {
      this.versusChosen = false
      this.showGameModes = true
    },

    HideBoth () {
      this.versusChosen = false
      this.showGameModes = false
    }

  }
}
</script>
