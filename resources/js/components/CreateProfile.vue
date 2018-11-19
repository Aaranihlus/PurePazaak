<template>
  <div class="container text-center" style="margin-top:30vh; background-color: black; padding: 2%; border-radius:12px; border:1px solid white;" v-show="showCreateProfileForm">

    <h1>Welcome to Pure Pazaak</h1>
    <p>Before you can play, you must first choose a username</p>

    <form v-show="!CheckForPlayerProfile()" v-on:submit.prevent="CreatePlayerProfile()">
      <div class="row mx-auto" style="max-width:50%;">
        <div class="col-8">
          <input class="form-control" type="text" name="username" placeholder="Choose your username" v-model="Username">
        </div>
        <div class="col-4">
          <input class="btn btn-primary" style="width:100%;" type="submit" value="Confirm">
        </div>
      </div>
    </form>

  </div>
</template>

<script>
export default {
  created () {

  },

  data () {
    return {
      Username: '',
      showCreateProfileForm: false
    }
  },

  methods: {

    CheckForPlayerProfile () {
      if (!localStorage.Username) {
        this.showCreateProfileForm = true
        this.$eventHub.$emit('NoProfileFound');
      } else {
        this.$eventHub.$emit('ProfileFound');
        return true
      }
    },

    CreatePlayerProfile () {

      if (this.Username == '') {
        console.log('please enter a username')
      } else {

        axios.post('/user/store', {
          username: this.Username
        })
        .then(function (response) {
          console.log(response);
        })
        .catch(function (error) {
          console.log(error);
        });

        //localStorage.Username = this.Username
        //localStorage.Credits = 500
        //localStorage.Wins = 0
        //localStorage.GamesPlayed = 0
        //this.$eventHub.$emit('ProfileCreated')
        //this.showCreateProfileForm = false

      }

    }

  }
}
</script>
