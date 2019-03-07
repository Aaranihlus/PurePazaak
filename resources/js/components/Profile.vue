<template>
  <div class="profile-panel" v-show="ShowProfile">
      <p class="profile-panel-item">{{ this.Username }}</p>
      <p class="profile-panel-item"><i class="far fa-play-circle"></i> {{ this.GamesPlayed }}</p>
      <p class="profile-panel-item"><i class="fas fa-trophy"></i> {{ this.Wins }}</p>
      <p class="profile-panel-item"><span><img src="/images/credit.png" style="width:1.4vw;" class="img-fluid"></span>{{ this.Credits }}</p>
  </div>
</template>

<script>
export default {

  data () {
    return {
      UserID: 0,
      Username: '',
      Credits: 0,
      Wins: 0,
      GamesPlayed: 0,
      ShowProfile: false
    }
  },

  created () {
    //If a player profile is found, get the players data from the database
    this.$eventHub.$on('ProfileFound', this.GetPlayerProfile);

    //When a new profile is created, get the players data from the database
    this.$eventHub.$on('ProfileCreated', this.GetPlayerProfile);
  },

  methods: {

    GetPlayerProfile () {
      if(localStorage.UserID){
        this.ShowProfile = true
        axios.get('/user/data/' + localStorage.UserID).then((response) => {
          this.UserID = response.data.id
          this.Username = response.data.username
          this.Credits = response.data.credits
          this.Wins = response.data.wins
          this.GamesPlayed = response.data.games_played
        });
      }
    }

  }

}
</script>
