<script setup>
    import { ref } from "vue";
    import axios from "axios";
    import Cookies from "js-cookie";

    const pin = ref("");
    const pinSymbol = ref("");

    function addNumber(number) {
        if(pin.value.length !== 4) {
            pin.value = pin.value + number;
            pinSymbol.value = pinSymbol.value + "*";
        }

        if(pin.value.length >= 4) {
            validatePin();
        }
    }

    function validatePin() {
        axios.post("/checkPin", {
            pin: pin.value,
            user: 0
        })
            .then(response => {
                switch (response.status){
                    case 200:
                        Cookies.set("token", response.data.token);
                        window.location.href= "/person/0";
                        break;
                }
            })
            .catch(error => {
                switch (error.response.status){
                    case 401:
                        pin.value = "";
                        pinSymbol.value = "";
                        alert("Wrong PIN");
                        break;
                    default:
                        alert("An error occurred. Please try again.");
                        break;
                }
            });
    }
</script>

<template>
    <div class="backGround">
        <div class="pinField">
            <div class="row">
                <div class="number" @click="addNumber(1)">1</div>
                <div class="number" @click="addNumber(2)">2</div>
                <div class="number" @click="addNumber(3)">3</div>
            </div>
            <div class="row">
                <div class="number" @click="addNumber(4)">4</div>
                <div class="number" @click="addNumber(5)">5</div>
                <div class="number" @click="addNumber(6)">6</div>
            </div>
            <div class="row">
                <div class="number" @click="addNumber(7)">7</div>
                <div class="number" @click="addNumber(8)">8</div>
                <div class="number" @click="addNumber(9)">9</div>
            </div>
            <div class="row">
                <div class="number" @click="addNumber(0)">0</div>
            </div>
            <div class="row">
                <div class="number">{{pinSymbol[0]}}</div>
                <div class="number">{{pinSymbol[1]}}</div>
                <div class="number">{{pinSymbol[2]}}</div>
                <div class="number">{{pinSymbol[3]}}</div>
            </div>
            <div class="row">
            </div>
        </div>
    </div>
</template>

<style scoped>
    .backGround {
        background-color: rgb(238, 238, 238,0.8);
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        padding: 2rem;
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        z-index: 999;
        width: 100%;
        height: 100%;
    }
    .pinField {
        background-color: white;
        top: 50%;
        left: 50%;
        position: fixed;
        transform: translate(-50%, -50%);
        display: grid;
        opacity: unset;
        z-index: 1000;
    }
    .row {
        display: flex;
        justify-content: center;
        margin: 0.5rem 0;
    }
    .number {
        background-color: #f3f4f6;
        border-radius: 0.5rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        width: 9rem;
        height: 9rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin: 0 0.5rem;
        cursor: pointer;
        transition: background-color 0.3s, transform 0.1s;
    }
</style>
