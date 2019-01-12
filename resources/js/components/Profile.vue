<template>
  <div class="profile-panel" v-show="ShowProfile">

    <div class="profile-panel-item">
      {{ this.Username }}
    </div>

    <div class="profile-panel-item" title="Deck Builder">
      <a href="/deck"><i class="fab fa-stack-overflow"></i> Deck</a>
    </div>

    <div class="profile-panel-item" title="Total Games Played">
      <i class="far fa-play-circle"></i> {{ this.GamesPlayed }}
    </div>

    <div class="profile-panel-item" title="Total Games Won">
      <i class="fas fa-trophy"></i> {{ this.Wins }}
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
      UserID: 0,
      Username: '',
      Credits: 0,
      Wins: 0,
      GamesPlayed: 0,
      ShowProfile: false
    }
  },

  created () {
    this.GetPlayerProfile();
    this.$eventHub.$on('ProfileFound', this.GetPlayerProfile)
    this.$eventHub.$on('ProfileCreated', this.GetPlayerProfile)

    /*if (localStorage.ActiveGameID) {
      axios.post('/game/'+ localStorage.ActiveGameID +'/leaveGame', {
        user_id: localStorage.UserID
      })
      .then((response) => {
        console.log(response)
      });
    }*/

  },

  methods: {

    GetPlayerProfile () {
      if (localStorage.UserID) {
        this.UserID = localStorage.UserID
        this.Username = localStorage.Username
        this.Credits = localStorage.Credits
        this.Wins = localStorage.Wins
        this.GamesPlayed = localStorage.GamesPlayed
        this.ShowProfile = true
        // Console log retrieved user data
        axios.get('/user/data/' + localStorage.UserID).then((response) => {
          console.log('User Data:')
          console.log(response)
        })
      }
    }

  }

}
</script>
