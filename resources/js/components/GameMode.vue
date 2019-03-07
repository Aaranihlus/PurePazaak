<template>

  <div class="container">

    <transition appear enter-active-class="animated bounceInRight" leave-active-class="animated bounceOutLeft" v-on:after-leave="">

      <div class="row" style="margin-top:20vh;" v-show="showGameModes">

        <div class="col-5 game-mode-panel" style="background: linear-gradient( rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6) ), url('/images/alpha-min.jpg'); background-size: cover;">
          <i class="fas fa-user fa-5x"></i>
          <h3>Practice</h3>
          <p>Play a practice game against the computer</p>
        </div>

        <div class="col-2"></div>

        <div class="col-5 game-mode-panel interactive" style="background: linear-gradient( rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6) ), url('/images/berta-min.jpg'); background-size: cover;" v-on:click="showGameModes = false">
          <i class="fas fa-users fa-5x"></i>
          <h3>versus</h3>
          <p>Go head-to-head with other players</p>
        </div>

        <div class="col-5 game-mode-panel interactive mt-4" style="background: linear-gradient( rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6) ), url('/images/ceaser-min.jpg'); background-size: cover;" v-on:click="showLeaderboards()">
          <i class="fas fa-poll fa-5x"></i>
          <h3>Leaderboards</h3>
          <p>See who fortune favours the most</p>
        </div>

        <div class="col-2"></div>

        <div class="col-5 game-mode-panel interactive mt-4" style="background: linear-gradient( rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6) ), url('/images/dora-min.png'); background-size: cover;" v-on:click="showDeckBuilder()">
          <i class="fab fa-stack-overflow fa-5x"></i>
          <h3>Deck Builder</h3>
          <p>Build your Side Deck</p>
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
    this.$eventHub.$on('VersusClosed', this.ShowGameModes);
  },

  methods: {

    showLeaderboards () {
      this.showGameModes = false
      this.$eventHub.$emit('showLeadboards');
    },

    showDeckBuilder () {
      this.$eventHub.$emit('showDeckBuilder');
    },

    ShowVersus () {
      this.$eventHub.$emit('VersusChosen');
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
