<template>
<div class="container-fluid">

    <div class="row">

        <div class="col-6 offset-2 text-center">
            <h3>All Cards</h3>
            <div class="row">
                <div class="col-2" v-for="(value, key) in sideDeckCards">
                    <img class="mx-auto" style="cursor: pointer" :key="key" :src="value.img" v-on:click="AddCardToSideDeck(value, key)">
                </div>
            </div>
        </div>

        <div class="col-2 text-center">
            <h3>Selected Cards</h3>
            <div class="row">
                <div class="col-6" v-for="(value, key) in selectedCards">
                    <img class="mx-auto" style="cursor: pointer" :key="key" :src="value.CardImage" v-on:click="RemoveCardFromSideDeck(value, key)">
                </div>
            </div>
        </div>

    </div>

    <button class="btn btn-primary" v-on:click="SaveDeck()">Save Deck</button>
    <button class="btn btn-primary" v-on:click="ClearDeck()">Clear Deck</button>

</div>
</template>

<script>
export default {
    created() {
      this.GetSavedDeck();
    },

    data() {
        return {
            selectedCards: [],

            sideDeckCards: {
                '+1': {
                    img: '/images/p1.png'
                },
                '+2': {
                    img: '/images/p2.png'
                },
                '+3': {
                    img: '/images/p3.png'
                },
                '+4': {
                    img: '/images/p4.png'
                },
                '+5': {
                    img: '/images/p5.png'
                },
                '+6': {
                    img: '/images/p6.png'
                },
                'flip1': {
                    img: '/images/f1.png'
                },
                'flip2': {
                    img: '/images/f2.png'
                },
                'flip3': {
                    img: '/images/f3.png'
                },
                'flip4': {
                    img: '/images/f4.png'
                },
                'flip5': {
                    img: '/images/f5.png'
                },
                'flip6': {
                    img: '/images/f6.png'
                },
                '-1': {
                    img: '/images/n1.png'
                },
                '-2': {
                    img: '/images/n2.png'
                },
                '-3': {
                    img: '/images/n3.png'
                },
                '-4': {
                    img: '/images/n4.png'
                },
                '-5': {
                    img: '/images/n5.png'
                },
                '-6': {
                    img: '/images/n6.png'
                }
            }
        }
    },

    methods: {

        AddCardToSideDeck(value, key) {
          if (this.selectedCards.length < 10) {
            this.selectedCards.push({ CardImage: value.img, CardID: key })
          }
        },

        RemoveCardFromSideDeck(value, key) {
            this.selectedCards.splice(key, 1)
        },

        GetSavedDeck() {
          this.selectedCards = JSON.parse(localStorage.sideDeck)
        },

        SaveDeck() {
            localStorage.sideDeck = JSON.stringify(this.selectedCards)
        },

        ClearDeck() {
            localStorage.sideDeck = ''
        }

    }
}
</script>
