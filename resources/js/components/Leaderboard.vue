<template>

  <transition appear enter-active-class="animated bounceInRight" leave-active-class="animated bounceOutLeft" v-on:after-leave="">

    <div class="container-flex" style="display:flex; justify-content:center; align-items: center;">

      <div class="container text-center" v-show="leaderboardOpen">

        <h2>leaderboards</h2>

        <br>

        <div class="row">

          <div class="col-4">
            <h3>Most Wins</h3>
            <ul class="list-group">
              <li v-for="(user, index) in mostWins" class="list-group-item" :class="{ 'active':(index === 0) }"><i class="fas fa-hashtag"></i>{{ index }} {{ user.username }} - {{ user.wins }} wins</li>
            </ul>
          </div>

          <div class="col-4">
            <h3>Most Games Played</h3>
            <ul class="list-group">
              <li v-for="(user, index) in mostGamesPlayed" class="list-group-item" :class="{ 'active':(index === 0) }"><i class="fas fa-hashtag"></i>{{ index }} {{ user.username }} - {{ user.games_played }} games</li>
            </ul>
          </div>

          <div class="col-4">
            <h3>Most Credits</h3>
            <ul class="list-group">
              <li v-for="(user, index) in mostCredits" class="list-group-item" :class="{ 'active':(index === 0) }"><i class="fas fa-hashtag"></i>{{ index }} {{ user.username }} - {{ user.credits }} credits</li>
            </ul>
          </div>

        </div>

      </div>

    </div>

  </transition>

</template>

<script>
export default {

  data() {
    return {
      leaderboardOpen: false,
      mostCredits: [],
      mostWins: [],
      mostGamesPlayed: []
    }
  },

  created() {
    this.$eventHub.$on('showLeadboards', this.showLeadboard)

    axios.get('/games/all').then(response => (this.openGames = response.data))

    axios.get('/user/leaderboard').then(response => {
      this.mostCredits = response.data.credits
      this.mostWins = response.data.wins
      this.mostGamesPlayed = response.data.games_played
    });

  },

  methods: {

    showLeadboard(){
      this.leaderboardOpen = true
    }

  }

}
</script>
