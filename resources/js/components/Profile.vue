<template>
  <div class="profile-panel" v-show="ShowProfile">
      <p v-if="playMusic" v-on:click="toggleMusic()" class="profile-panel-item"><i class="fas fa-volume-up"></i></p>
      <p v-else v-on:click="toggleMusic()" class="profile-panel-item"><i class="fas fa-volume-down"></i></p>
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
      ShowProfile: false,
      playMusic: true,
      mainAudio: new Audio('/audio/cantina_tune.mp3')
    }
  },

  created () {
    //If a player profile is found, get the players data from the database
    this.$eventHub.$on('ProfileFound', this.GetPlayerProfile)

    //When a new profile is created, get the players data from the database
    this.$eventHub.$on('ProfileCreated', this.GetPlayerProfile)

    this.mainAudio.volume = 0.07
    this.mainAudio.play()
  },

  methods: {

    toggleMusic () {
      this.playMusic = !this.playMusic
      if (this.playMusic) {
        this.mainAudio.volume = 0.07
      } else {
        this.mainAudio.volume = 0
      }
    },

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
