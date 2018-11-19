<template>
<div class="container-fluid text-center">
    <div class="row">

        <div class="col-6">
            <div class="container">
                <h2><i v-show="this.currentPlayerTurn === 1" class="fas fa-circle turn-active"></i> {{ players[1].name }} - {{ players[1].set_score }}</h2>
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
                <p>Your hand</p>
                <div class="card-row">
                    <div class="card"></div>
                    <div class="card"></div>
                    <div class="card"></div>
                    <div class="card"></div>
                </div>
                <br>

                <div v-show="this.currentPlayerTurn == 1">
                    <button class="btn btn-primary" v-on:click="EndTurn()">End Turn</button>
                    <button class="btn btn-primary" v-on:click="EndTurn()">Stand</button>
                    <button class="btn btn-primary" v-on:click="EndTurn()">Forfeit</button>
                </div>

            </div>
        </div>

        <div class="col-6">
            <div class="container">
                <h2>{{ players[2].set_score }} - {{ players[2].name }} <i v-show="this.currentPlayerTurn === 2" class="fas fa-circle turn-active"></i></h2>
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
                <p>opponent hand</p>
                <div class="card-row">
                    <div class="card"></div>
                    <div class="card"></div>
                    <div class="card"></div>
                    <div class="card"></div>
                </div>
                <div v-show="this.currentPlayerTurn == 2">
                    <button class="btn btn-primary" v-on:click="EndTurn()">End Turn</button>
                    <button class="btn btn-primary" v-on:click="EndTurn()">Stand</button>
                    <button class="btn btn-primary" v-on:click="EndTurn()">Forfeit</button>
                </div>
                <br>
            </div>
        </div>

    </div>
</div>
</template>

<script>
export default {

    data() {
        return {

            players: {
                1: {
                    name: 'Chungus',
                    hand: {},
                    set_score: 0,
                    sets_won: 0,
                    num_cards_in_field: 0,
                    cards_in_field: []
                },
                2: {
                    name: 'Atton Rand',
                    hand: {},
                    set_score: 0,
                    sets_won: 0,
                    num_cards_in_field: 0,
                    cards_in_field: []
                }
            },

            totalCardsDrawn: 0,
            currentPlayerTurn: 1,
            nextDealerCard: 0,

            dealerCards: {
                1: {
                    img: '/images/g1.png'
                },
                2: {
                    img: '/images/g2.png'
                },
                3: {
                    img: '/images/g3.png'
                },
                4: {
                    img: '/images/g4.png'
                },
                5: {
                    img: '/images/g5.png'
                },
                6: {
                    img: '/images/g6.png'
                },
                7: {
                    img: '/images/g7.png'
                },
                8: {
                    img: '/images/g8.png'
                },
                9: {
                    img: '/images/g9.png'
                },
                10: {
                    img: '/images/g10.png'
                }
            }

        }
    },

    mounted() {
        this.DealCardToPlayer(1);
    },

    methods: {

        EndTurn() {
            if (this.currentPlayerTurn === 1) {
                this.currentPlayerTurn += 1
            } else {
                this.currentPlayerTurn -= 1
            }
            this.DealCardToPlayer(this.currentPlayerTurn);
        },

        DealCardToPlayer(playerNumber) {
            this.PlaySound()
            this.nextDealerCard = Math.floor((Math.random() * 10) + 1)
            this.players[playerNumber].num_cards_in_field += 1
            this.players[playerNumber].cards_in_field.push(this.nextDealerCard)
            if (this.totalCardsDrawn === 0) {
                window.$('#p1c1').append('<img class="card-image" src="' + this.dealerCards[this.nextDealerCard].img + '">')
            } else {
                window.$('#p' + playerNumber + 'c' + this.players[playerNumber].num_cards_in_field).append('<img class="card-image" src="' + this.dealerCards[this.nextDealerCard].img + '">')
            }
            this.totalCardsDrawn += 1;
            this.UpdatePlayerScore();
        },

        UpdatePlayerScore() {
            this.players[this.currentPlayerTurn].set_score = this.players[this.currentPlayerTurn].cards_in_field.reduce((a, b) => a + b, 0);
        },

        PlaySound() {
            var audio = new Audio('/audio/DrawCard.wav');
            audio.volume = 0.1;
            audio.play();
        }

    }

}
</script>
