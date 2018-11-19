<template>
  <div class="container">

    <div class="row" style="margin-top:25vh;" v-show="showGameModes">
      <div class="col-5 game-mode-panel">
        <i class="fas fa-user fa-5x"></i>
        <h2>Practice</h2>
        <p>Play a practice game against the computer</p>
      </div>
      <div class="col-2"></div>
      <div class="col-5 game-mode-panel" v-on:click="ClickVersus()" style="cursor: pointer;">
        <i class="fas fa-users fa-5x"></i>
        <h3>versus</h3>
        <p>Go head-to-head with other players</p>
      </div>
    </div>

    <div class="row" style="margin-top:25vh;" v-show="versusChosen">
      <div class="col-5 game-mode-panel">
        <i class="fas fa-plus-square fa-5x"></i>
        <h2>Create Game</h2>
        <p>Create a new public game</p>
      </div>
      <div class="col-2"></div>
      <div class="col-5 game-mode-panel">
        <i class="fas fa-sign-in-alt fa-5x"></i>
        <h3>Join Game</h3>
        <p>Join another players public game</p>
      </div>
      <p style="cursor: pointer;" v-on:click="BackToGameModes()"><i class="fas fa-angle-left"></i> Back</p>
    </div>

  </div>
</template>

<script>
export default {

  data () {
    return {
      showGameModes: true,
      versusChosen: false
    }
  },

  created () {
    this.$eventHub.$on('NoProfileFound', this.ChooseGameMode)

    this.$eventHub.$on('ProfileFound', () => {
      this.showGameModes = true
    })

    this.$eventHub.$on('ProfileCreated', () => {
      this.showGameModes = true
    })

  },

  methods: {
    ChooseGameMode () {
      this.showGameModes = false
    },

    ClickVersus () {
      this.versusChosen = true
      this.showGameModes = false
    },

    BackToGameModes () {
      this.versusChosen = false
      this.showGameModes = true
    }
  }
}
</script>
