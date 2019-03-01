<template>

  <transition appear enter-active-class="animated bounceInRight" leave-active-class="animated bounceOutLeft" v-on:after-leave="">
    <div class="container-fluid p-4" v-show="deckBuilderVisible">

      <p v-on:click="hideBuilder()" style="cursor: pointer;"><i class="fas fa-angle-left"></i> Back</p>

      <div class="row">
        <div class="col-12">
          <h3>All Cards</h3>
          <div class="row">
            <div v-for="(value, key) in sideDeckCardsPlus">
              <div class="card m-3">
                <img class="mx-auto card-image" style="cursor: pointer" :key="key" :src="value.img" v-on:click="AddCardToSideDeck(value, key)">
              </div>
            </div>
          </div>
          <div class="row">
            <div v-for="(value, key) in sideDeckCardsMinus">
              <div class="card m-3">
                <img class="mx-auto card-image" style="cursor: pointer" :key="key" :src="value.img" v-on:click="AddCardToSideDeck(value, key)">
              </div>
            </div>
          </div>
        </div>
      </div>

      <hr>

      <div class="row">
        <div class="col-12">
          <h3>Selected Cards</h3>
          <div class="row">
            <div v-for="(value, key) in selectedCards">
              <transition appear enter-active-class="animated bounceInRight">
                <div class="card m-3">
                  <img class="mx-auto card-image" style="cursor: pointer" :key="key" :src="value.CardImage" v-on:click="RemoveCardFromSideDeck(value, key)">
                </div>
              </transition>
            </div>
          </div>
        </div>
      </div>

      <button class="btn btn-primary" v-on:click="SaveDeck()">Save Deck</button>
      <button class="btn btn-primary" v-on:click="ClearDeck()">Clear Deck</button>

      <h1 v-if="responseMessage">{{ responseMessage }}</h1>

    </div>
  </transition>
</template>

<script>
export default {

  created() {
    this.GetSavedDeck();
    this.$eventHub.$on('showDeckBuilder', this.showBuilder);
  },

  data() {
    return {
      selectedCards: [],
      responseMessage: '',
      deckBuilderVisible: false,

      sideDeckCardsPlus: {
        '+1': { img: '/images/p1.png' },
        '+2': { img: '/images/p2.png' },
        '+3': { img: '/images/p3.png' },
        '+4': { img: '/images/p4.png' },
        '+5': { img: '/images/p5.png' },
        '+6': { img: '/images/p6.png' }
      },

      sideDeckCardsFlip: {
        'f1': { img: '/images/f1.png' },
        'f2': { img: '/images/f2.png' },
        'f3': { img: '/images/f3.png' },
        'f4': { img: '/images/f4.png' },
        'f5': { img: '/images/f5.png' },
        'f6': { img: '/images/f6.png' }
      },

      sideDeckCardsMinus: {
        '-1': { img: '/images/n1.png' },
        '-2': { img: '/images/n2.png' },
        '-3': { img: '/images/n3.png' },
        '-4': { img: '/images/n4.png' },
        '-5': { img: '/images/n5.png' },
        '-6': { img: '/images/n6.png' }
      }

    }
  },

  methods: {

    showBuilder () {
      this.deckBuilderVisible = true;
    },

    hideBuilder () {
      this.deckBuilderVisible = false;
      this.$eventHub.$emit('BuilderClosed');
    },

    AddCardToSideDeck(value, key) {
      if ( this.selectedCards.length < 10 ) {
        this.selectedCards.push({ CardImage: value.img, CardID: key })
      } else {
        this.responseMessage = 'you can not select more than 10 cards!'
      }
    },

    RemoveCardFromSideDeck(value, key) {
      this.selectedCards.splice(key, 1)
    },

    GetSavedDeck() {
      axios.get('/user/get_sidedeck/' + localStorage.UserID).then(response => {
        if(typeof response.data == 'string') {
          this.selectedCards = []
        } else {
          this.selectedCards = response.data
        }
      });
    },

    SaveDeck() {
      if ( this.selectedCards.length < 10 ) {
        this.responseMessage = 'you must select at least 10 cards for your side deck!'
      } else {
        axios.post('/user/update_sidedeck', {
          user_id: localStorage.UserID,
          chosen_side_deck: JSON.stringify(this.selectedCards)
        })
        .then((response) => {
          this.responseMessage = "Deck Saved"
        })
        .catch(function(error) {
          this.responseMessage = "Failed to Save Deck"
        });
      }
    },

    ClearDeck() {
      this.selectedCards = [];
    }

  }
}
</script>
