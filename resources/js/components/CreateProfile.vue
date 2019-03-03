<template>
  <div class="container-fluid text-center flex flex-center" style="overflow-x: hidden;">

    <transition appear enter-active-class="animated bounceInRight" leave-active-class="animated bounceOutLeft" v-on:after-leave="profileCreatedSuccessfully = true">
      <div class="round-border" style="background-color: black; padding: 2%; width:50%; margin-top:19%;" v-show="showCreateProfileForm">
        <h1>Welcome to Pure Pazaak</h1>
        <p style="margin-top: 5px; margin-bottom: 10px;">Before you can play, you must first choose a username</p>

        <form v-on:submit.prevent="CreatePlayerProfile()">
          <div class="row mx-auto" style="max-width:50%;">
            <div class="col-8">
              <input class="form-control" type="text" name="username" placeholder="Choose your username" v-model="Username">
            </div>
            <div class="col-4">
              <input class="btn btn-primary" style="width:100%;" type="submit" value="Confirm">
            </div>
          </div>
        </form>

        <transition enter-active-class="animated pulse">
          <div class="round-border text-center" style="background-color: #660000; padding: 2%; margin-top: 2vh;" v-show="profileError">
            <i class="fas fa-exclamation-triangle"></i> {{ this.profileError }}
          </div>
        </transition>

      </div>
    </transition>

    <transition enter-active-class="animated bounceInRight" leave-active-class="animated bounceOutLeft" v-on:after-leave="GoToMainMenu()">
      <div class="round-border" style="background-color: black; padding: 2%; width:50%; margin-top:19%;" v-show="profileCreatedSuccessfully">
        <h1>Congratulations!</h1>
        <p style="margin-top: 5px; margin-bottom: 10px;">Hello {{ this.Username }}, here are some credits to get you started</p>
        <div class="flex flex-center">
          <img src="/images/credit.png" style="width:10%" class="img-fluid">
          <h2>500</h2>
        </div>
        <button v-on:click="Play()" class="btn btn-primary">Play</button>
      </div>
    </transition>

  </div>

</template>


<script>

export default {

  created () {
    this.CheckForPlayerProfile()
  },

  data () {
    return {
      Username: '',
      showCreateProfileForm: false,
      profileCreatedSuccessfully: false,
      profileError: ''
    }
  },

  methods: {

    CheckForPlayerProfile () {
      if (!localStorage.UserID) {
        this.showCreateProfileForm = true
      } else {
        this.$eventHub.$emit('ProfileFound');
      }
    },

    Play() {
      this.$eventHub.$emit('ProfileCreated');
      this.profileCreatedSuccessfully = false
    },

    GoToMainMenu () {
      this.showCreateProfileForm = false
    },

    CreatePlayerProfile () {
      if (this.Username == '') {
        this.profileError = 'please enter a username!'
      } else if (this.Username.length > 12) {
        this.profileError = 'chosen username is too long!'
      } else {
        axios.post('/user/store', {
          username: this.Username
        })
        .then((response) => {
          this.showCreateProfileForm = !this.showCreateProfileForm
          localStorage.UserID = response.data.id
        })
        .catch((error) => {
          this.profileError = 'username is already in use!'
        });
      }
    }

  }
}
</script>
