<template>
  <div class="profile-panel" v-show="ShowProfile">

    <div class="profile-panel-item">
      <p>{{ this.Username }}</p>
    </div>

    <div class="profile-panel-item" title="Deck Builder">
      <a href="/deck"><i class="fab fa-stack-overflow"></i> Deck</a>
    </div>

    <div class="profile-panel-item" title="Total Games Played">
      <p><i class="far fa-play-circle"></i> {{ this.GamesPlayed }}</p>
    </div>

    <div class="profile-panel-item" title="Total Games Won">
      <p><i class="fas fa-trophy"></i> {{ this.Wins }}</p>
    </div>

    <div class="profile-panel-item" title="Credit Balance">
      <img src="/images/credit.png" style="width:15%;" class="img-fluid">{{ this.Credits }}
    </div>

  </div>

</template>

<script>
export default {

  data () {
    return {
      Username: '',
      Credits: 0,
      Wins: 0,
      GamesPlayed: 0,
      ShowProfile: false
    }
  },

  created () {
    this.GetPlayerProfile()
    this.$eventHub.$on('ProfileFound', this.GetPlayerProfile)
    this.$eventHub.$on('ProfileCreated', this.GetPlayerProfile)
  },

  methods: {

    GetPlayerProfile () {
      if (localStorage.Username) {
        this.Username = localStorage.Username
        this.Credits = localStorage.Credits
        this.Wins = localStorage.Wins
        this.GamesPlayed = localStorage.GamesPlayed
        this.ShowProfile = true
      }
    }

  }

}
</script>
