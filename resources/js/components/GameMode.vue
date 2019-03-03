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
        <div class="col-5 game-mode-panel interactive" v-on:click="showGameModes = false, versusChosen = true">
          <i class="fas fa-users fa-5x"></i>
          <h3>versus</h3>
          <p>Go head-to-head with other players</p>
        </div>
      </div>
    </transition>

    <transition appear enter-active-class="animated bounceInRight" leave-active-class="animated bounceOutLeft" v-on:after-leave="">
      <div class="row" style="margin-top:25vh;" v-show="versusChosen">
        <div class="col-5 game-mode-panel interactive">
          <i class="fas fa-plus-square fa-5x"></i>
          <h2 v-on:click="OpenCreateGame()">Create Game</h2>
          <p>Create a new public game</p>
        </div>
        <div class="col-2"></div>
        <div class="col-5 game-mode-panel interactive">
          <i class="fas fa-sign-in-alt fa-5x"></i>
          <a href="/games"><h3>Join Game</h3></a>
          <p>Join another players public game</p>
        </div>
        <h4 style="cursor: pointer;" v-on:click="versusChosen = false, showGameModes = true"><i class="fas fa-angle-left"></i> Back</h4>
      </div>
    </transition>

    <transition appear enter-active-class="animated bounceInRight" leave-active-class="animated bounceOutLeft">
      <div v-if="createGameActive" class="modal game-model-panel" style="display: block; margin-top: 4%;">
        <div class="modal-dialog" role="document" style="border:1px solid white;">
          <div class="modal-content">
            <div class="modal-header" style="background-color:black;">
              <h4 class="modal-title">Create New Game</h4>
            </div>

            <div class="modal-body text-left">
              <label>Wager</label>
              <input type="number" v-model="gameWager">
            </div>

            <div class="modal-footer p-2" style="background-color:black;">
              <button type="button" class="btn btn-primary" v-on:click="CancelCreateGame()"> Cancel </button>
              <button type="button" class="btn btn-primary" v-on:click="CreateNewGame()"> Accept </button>
            </div>
          </div>
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
