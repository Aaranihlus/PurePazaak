<template>
  <div class="container-fluid text-center">
    <div class="row">

      <div class="col-6">
        <div class="container">
          <h2>{{ players[1].username }}</h2>
          <i class="fas fa-award fa-2x turn-inactive"></i>
          <i class="fas fa-award fa-2x turn-inactive"></i>
          <i class="fas fa-award fa-2x turn-inactive"></i>
          <div class="card-row">
            <div class="card" id="p1c1"></div>
            <div class="card" id="p1c2"></div>
            <div class="card" id="p1c3"></div>
          </div>
          <div class="card-row">
            <div class="card" id="p1c4"></div>
            <div class="card" id="p1c5"></div>
            <div class="card" id="p1c6"></div>
          </div>
          <div class="card-row">
            <div class="card" id="p1c7"></div>
            <div class="card" id="p1c8"></div>
            <div class="card" id="p1c9"></div>
          </div>
          <br>

          <div v-show="this.myPlayerIndex == 1">
            <p>Side Deck</p>
            <div class="card-row" v-if="players[1].side_deck">
              <div class="card" v-for="(card, index) in this.players[1].side_deck" v-bind:style="{ backgroundImage: 'url(' + card.CardImage + ')' }" v-on:click="PlaySideCard(card, index, 1)"></div>
            </div>
            <br>
            <div v-show="this.currentPlayerTurn == this.myPlayerIndex">
              <button class="btn btn-primary" v-on:click="EndTurn()">End Turn</button>
              <button class="btn btn-primary" v-on:click="Stand()">Stand</button>
              <button class="btn btn-primary" v-on:click="Forfeit()">Forfeit</button>
            </div>
          </div>

        </div>
      </div>

      <div class="col-6">
        <div class="container">
          <h2>{{ players[2].username }}</h2>
          <i class="fas fa-award fa-2x turn-inactive"></i>
          <i class="fas fa-award fa-2x turn-inactive"></i>
          <i class="fas fa-award fa-2x turn-inactive"></i>
          <div class="card-row">
            <div class="card" id="p2c1"></div>
            <div class="card" id="p2c2"></div>
            <div class="card" id="p2c3"></div>
          </div>
          <div class="card-row">
            <div class="card" id="p2c4"></div>
            <div class="card" id="p2c5"></div>
            <div class="card" id="p2c6"></div>
          </div>
          <div class="card-row">
            <div class="card" id="p2c7"></div>
            <div class="card" id="p2c8"></div>
            <div class="card" id="p2c9"></div>
          </div>
          <br>

          <div v-show="this.myPlayerIndex == 2">
          <p>Side Deck</p>
          <div class="card-row" v-if="players[2].side_deck">
            <div class="card" v-for="(card, index) in this.players[2].side_deck" v-bind:style="{ backgroundImage: 'url(' + card.CardImage + ')' }" v-on:click="PlaySideCard(card, index, 1)"></div>
          </div>
          <br>
          <div v-show="this.currentPlayerTurn == this.myPlayerIndex">
            <button class="btn btn-primary" v-on:click="EndTurn()">End Turn</button>
            <button class="btn btn-primary" v-on:click="Stand()">Stand</button>
            <button class="btn btn-primary" v-on:click="Forfeit()">Forfeit</button>
          </div>
          </div>


        </div>
      </div>

    </div>
  </div>
</template>

<script>
export default {

  data() {
    return {

      gameData: {},
      myPlayerIndex: 0,
      gameID: window.location.href.split('/').pop(),
      players: {
        1: { id: '', username: '', side_deck: [], num_cards_in_field: 0, cards_in_field: [] },
        2: { id: '', username: '', side_deck: [], num_cards_in_field: 0, cards_in_field: [] },
      },
      totalCardsDrawn: 0,
      currentPlayerTurn: 1,
      nextDealerCard: 0,

      dealerCards: {
        1: { img: '/images/g1.png' },
        2: { img: '/images/g2.png' },
        3: { img: '/images/g3.png' },
        4: { img: '/images/g4.png' },
        5: { img: '/images/g5.png' },
        6: { img: '/images/g6.png' },
        7: { img: '/images/g7.png' },
        8: { img: '/images/g8.png' },
        9: { img: '/images/g9.png' },
        10: { img: '/images/g10.png' }
      }

    }
  },

  mounted () {
    //this.GetPlayerSideDeck();
    //this.DealCardToPlayer(1);
    //console.log(this.players[1].username)
  },

  created () {
    // Get Game Data
    axios.get('/game/data/' + this.gameID).then(response => {
      this.gameData = response.data

      // The creator of the game always joins first, so we will grab their data and assign it to player 1
      axios.get('/user/data/' + this.gameData.creator_id).then(response => {
        this.AddPlayer(1, response)
      });

      // When the opponent joins the game, we retrive their data and store them as player 2
      axios.get('/user/data/' + this.gameData.opponent_id).then(response => {
        this.AddPlayer(2, response)
      })
    });

    // An opponent_id will not be available as soon as the game starts, so the creator of the game must listen for another player joining
    window.Echo.private('join.game.' + this.gameID).listen('PlayerJoinedGame', e => {
      console.log('Player is joining the game!')
      // The player that joins is assigned to player 2
      axios.get('/user/data/' + e.opponent.id).then(response => {
        this.AddPlayer(2, response)
      })
    });

    window.Echo.private('player.endturn.game.' + this.gameID).listen('PlayerEndTurn', e => {
      console.log(e);
      this.DealCardToPlayer(e.data.player_index, e.random_dealer_card);
    });

    window.Echo.private('player.forfeit.game.' + this.gameID).listen('PlayerForfeit', e => {
      console.log(e);
    });

    window.Echo.private('player.playcard.game.' + this.gameID).listen('PlayerPlayCard', e => {
      console.log(e);
    });

    window.Echo.private('player.playcard.game.' + this.gameID).listen('PlayerStand', e => {
      console.log(e);
    });

    /*window.Echo.private('player.leftgame.game.' + this.gameID).listen('PlayerLeftGame', e => {
      console.log(e);
    });*/

  },

  methods: {

    EndTurn() {
      axios.post('/game/'+ this.gameID +'/endturn', {
        username: localStorage.Username,
        user_id: localStorage.UserID,
        game_id: this.gameID,
        player_index: this.myPlayerIndex
      })
      .then((response) => {
        console.log(response)
      });
    },

    Stand() {
      axios.post('/game/'+ this.gameID +'/setStand', {
        username: localStorage.Username,
        user_id: localStorage.UserID,
        game_id: this.gameID
      })
      .then((response) => {
        console.log(response)
      });
    },

    Forfeit() {
      axios.post('/game/'+ this.gameID +'/forfeitGame', {
        username: localStorage.Username,
        user_id: localStorage.UserID,
        game_id: this.gameID
      })
      .then((response) => {
        console.log(response)
      });
    },

    AddPlayer (PlayerNumber, Data) {
      console.log(Data);
      this.players[PlayerNumber].username = Data.data.username;
      this.players[PlayerNumber].id = Data.data.id;
      this.players[PlayerNumber].side_deck = [];
      let sideDeckCards = JSON.parse(Data.data.side_deck)
      for (let i = 0; i < 4; i++) {
        this.players[PlayerNumber].side_deck.push(sideDeckCards[Math.floor((Math.random() * 10) + 0)]);
      }

      if (this.players[PlayerNumber].id == localStorage.UserID) {
        this.myPlayerIndex = PlayerNumber
      }

    },


    DealCardToPlayer(playerNumber, dealerCard) {
      this.PlaySound('DrawCard')

      this.nextDealerCard = dealerCard
      this.players[playerNumber].num_cards_in_field += 1
      this.players[playerNumber].cards_in_field.push(this.nextDealerCard)
      if (this.totalCardsDrawn === 0) {
        window.$('#p1c1').append('<img class="card-image" src="' + this.dealerCards[this.nextDealerCard].img + '">')
      } else {
        window.$('#p' + playerNumber + 'c' + this.players[playerNumber].num_cards_in_field).append('<img class="card-image" src="' + this.dealerCards[this.nextDealerCard].img + '">')
      }
      this.totalCardsDrawn += 1;
      this.UpdatePlayerScore(playerNumber);

      if (playerNumber == 1) {
        this.currentPlayerTurn = 2
      } else {
        this.currentPlayerTurn = 1
      }

    },


    PlaySideCard(card, index, playerNumber) {
      this.players[playerNumber].num_cards_in_field += 1
      window.$('#p' + playerNumber + 'c' + this.players[playerNumber].num_cards_in_field).append('<img class="card-image" src="' + this.players[playerNumber].side_deck[index].CardImage + '">')
      this.players[1].side_deck.splice(index, 1)
    },

    UpdatePlayerScore() {
      this.players[this.currentPlayerTurn].set_score = this.players[this.currentPlayerTurn].cards_in_field.reduce((a, b) => a + b, 0)
      if (this.players[this.currentPlayerTurn].set_score > 20) {
        this.PlaySound('over20')
      }
    },

    PlaySound(SoundName) {
      var audio = new Audio('/audio/' + SoundName + '.wav');
      audio.volume = 0.1;
      audio.play();
    }

  }

}
</script>
