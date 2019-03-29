<template>
  <div class="container-fluid text-center">
    <div class="row">

      <div class="col-5">
        <div class="container">
          <h2>{{ players[1].username }}</h2>
          <p>Set Score - {{ players[1].set_score }}</p>
          <i class="fas fa-award fa-2x set-not-won"></i>
          <i class="fas fa-award fa-2x set-not-won"></i>
          <i class="fas fa-award fa-2x set-not-won"></i>
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
              <div class="card interactive" v-for="(card, index) in this.players[1].side_deck" v-bind:style="{ backgroundImage: 'url(' + card.CardImage + ')' }" v-on:click="PlaySideCard(card, index, 1)"></div>
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

      <div class="col-2">

        <div class="Waiting" style="display: flex; align-items: center; justify-content: center; flex-direction: column;" v-show="this.waitingForPlayers">
          <h2>Waiting for opponent</h2>
          <i class="fas fa-spinner fa-spin fa-4x"></i>
        </div>

        <div class="ScoreCounter" v-show="this.gameStarted">
          <h2>Current Set</h2>
          <h3>{{ currentSet }}</h3>
        </div>

        <div class="ReadyStatus" v-show="this.ShowReadyStatus">
          <button class="btn btn-primary mt-5" v-on:click="ReadyUp(myPlayerIndex)">Ready up</button>
          <hr>
          <p v-if="this.players[1].ready">Player one: Ready</p>
          <i class="fas fa-thumbs-up fa-3x" v-if="this.players[1].ready"></i>
          <hr>
          <p v-if="this.players[2].ready">Player two: Ready</p>
          <i class="fas fa-thumbs-up fa-3x" v-if="this.players[2].ready"></i>
        </div>

      </div>

      <div class="col-5">
        <div class="container">
          <h2>{{ players[2].username }}</h2>
          <p>Set Score - {{ players[2].set_score }}</p>
          <i class="fas fa-award fa-2x set-not-won"></i>
          <i class="fas fa-award fa-2x set-not-won"></i>
          <i class="fas fa-award fa-2x set-not-won"></i>
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
              <div class="card interactive" v-for="(card, index) in this.players[2].side_deck" v-bind:style="{ backgroundImage: 'url(' + card.CardImage + ')' }" v-on:click="PlaySideCard(card, index, 2)"></div>
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
      gameStarted: false,
      currentSet: 1,
      setsToWinGame: 3,
      totalCardsDrawn: 0,
      currentPlayerTurn: 1,
      nextDealerCard: 0,
      ShowReadyStatus: false,
      dealToPlayer: 0,
      waitingForPlayers: true,

      players: {
        1: { id: '', username: '', side_deck: [], num_cards_in_field: 0, cards_in_field: [], set_score: 0, sets_won: 0, ready: false },
        2: { id: '', username: '', side_deck: [], num_cards_in_field: 0, cards_in_field: [], set_score: 0, sets_won: 0, ready: false },
      },

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
      });

    });

    // An opponent_id will not be available as soon as the game starts, so the creator of the game must listen for another player joining
    window.Echo.private('game.event.'+this.gameID).listen('PlayerJoinedGame', e => {
      // The player that joins is assigned to player 2
      axios.get('/user/data/' + e.opponent.id).then(response => {
        this.AddPlayer(2, response)
        this.waitingForPlayers = false
        this.ShowReadyStatus = true
      });
    });

    window.Echo.private('game.event.'+this.gameID).listen('StartGame', e => {
      this.DealCardToPlayer(1, e.random_dealer_card);
      this.gameStarted = true;
      this.ShowReadyStatus = false;
    });

    window.Echo.private('game.event.'+this.gameID).listen('ReadyUp', e => {
      this.MarkAsReady(e);
    });


    //When the current player ends their turn, make the other players turn begin, and give them the random card
    window.Echo.private('game.event.'+this.gameID).listen('PlayerEndTurn', e => {
      this.DealCardToPlayer(this.dealToPlayer, e.random_dealer_card);
    });

    window.Echo.private('game.event.'+this.gameID).listen('PlayerForfeit', e => {

    });

    window.Echo.private('game.event.'+this.gameID).listen('PlayerPlayCard', e => {
      this.PlaySideCard(e.data.card, e.data.index, e.data.playerNumber)
    });

    window.Echo.private('game.event.'+this.gameID).listen('PlayerStand', e => {

    });

  },

  methods: {

    ReadyUp (player_index) {
      axios.post('/game/ready/' + this.gameID, {
        game_id: this.gameID,
        player_index: player_index
      });
    },

    MarkAsReady (data) {
      this.players[data.player_index].ready = true;
      if(this.myPlayerIndex == 1 && this.players[1].ready == true && this.players[2].ready == true){
        this.StartGame();
      }
    },

    StartGame () {
      this.gameStarted = true;
      if( this.myPlayerIndex == 1 ) {
        // Make a request to the server to serve the first card, starting the game
        axios.post('/game/start/'+ this.gameID, {
          game_id: this.gameID
        });
      }
    },

    EndTurn () {
      axios.post('/game/'+ this.gameID +'/endturn', {
        username: localStorage.Username,
        user_id: localStorage.UserID,
        game_id: this.gameID,
        player_index: this.myPlayerIndex
      });
    },

    Stand () {
      axios.post('/game/'+ this.gameID +'/setStand', {
        username: localStorage.Username,
        user_id: localStorage.UserID,
        game_id: this.gameID
      });
    },

    Forfeit () {
      axios.post('/game/'+ this.gameID +'/forfeitGame', {
        username: localStorage.Username,
        user_id: localStorage.UserID,
        game_id: this.gameID
      });
    },

    AddPlayer (PlayerNumber, Data) {
      this.players[PlayerNumber].username = Data.data.username;
      this.players[PlayerNumber].id = Data.data.id;
      this.players[PlayerNumber].side_deck = [];
      let sideDeckCards = JSON.parse(Data.data.side_deck)
      for (let i = 0; i < 4; i++) {
        let randomCard = Math.floor((Math.random() * 10) + 0);
        this.players[PlayerNumber].side_deck.push(sideDeckCards[randomCard]);
        //sideDeckCards.splice(randomCard, 1)
      }
      if (this.players[PlayerNumber].id == localStorage.UserID) {
        this.myPlayerIndex = PlayerNumber
        if (this.myPlayerIndex == 2) {
          this.waitingForPlayers = false
          this.ShowReadyStatus = true
        }
      }
    },

    DealCardToPlayer(playerNumber, dealerCard) {

      if(this.currentPlayerTurn == 1){
        this.currentPlayerTurn = 2
        this.dealToPlayer = 2
      } else {
        this.currentPlayerTurn = 1
        this.dealToPlayer = 1
      }

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
    },

    PlaySideCard(card, index, playerNumber) {

      this.players[playerNumber].num_cards_in_field += 1

      if( this.players[playerNumber].side_deck[index] == undefined ) {
        window.$('#p' + playerNumber + 'c' + this.players[playerNumber].num_cards_in_field).append('<img class="card-image" src="' + card.CardImage + '">')
      } else {
        window.$('#p' + playerNumber + 'c' + this.players[playerNumber].num_cards_in_field).append('<img class="card-image" src="' + this.players[playerNumber].side_deck[index].CardImage + '">')
        axios.post('/game/'+ this.gameID +'/playcard', {
          username: localStorage.Username,
          user_id: localStorage.UserID,
          game_id: this.gameID,
          playerNumber: playerNumber,
          card: card
        });
      }

      if(card.CardID.charAt(0).toString() == "+"){
        this.players[playerNumber].set_score += parseInt(card.CardID.charAt(1));
      }

      if(card.CardID.charAt(0).toString() == "-"){
        this.players[playerNumber].set_score -= parseInt(card.CardID.charAt(1));
      }

      this.players[playerNumber].side_deck.splice(index, 1)
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
