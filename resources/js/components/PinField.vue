<script setup>
    import { ref, defineProps } from "vue";
    import axios from "axios";
    import Cookies from "js-cookie";

    const pin = ref("");
    const pinSymbol = ref("");
    const inputEnabled = ref(true);
    const isShaking = ref(false);
    const props = defineProps({
        id: {
            type: Number || null,
            required: true
        }
    });

    function addNumber(number) {
        pin.value = pin.value + number;
        pinSymbol.value = pinSymbol.value + "*";
        if (pin.value.length >=4) {
            inputEnabled.value = false;
            validatePin();
        }
    }

    function validatePin() {
        axios.post("/checkPin", {
            pin: pin.value,
            user: props.id
        })
            .then(response => {
                switch (response.status){
                    case 200:
                        Cookies.set("token", response.data.token);
                        window.location.href= "/person/" + props.id;
                        break;
                }
            })
            .catch(error => {
                isShaking.value = true;
                setTimeout(() => isShaking.value = false, 400)
                pin.value = "";
                pinSymbol.value = "";
                inputEnabled.value = true;
            });
    }
</script>

<template>
    <div class="backGround">
        <div class="pinField" :class="{shake: isShaking}">
            <div class="row">
                <div class="number" @click="inputEnabled && addNumber(1)">1</div>
                <div class="number" @click="inputEnabled && addNumber(2)">2</div>
                <div class="number" @click="inputEnabled && addNumber(3)">3</div>
            </div>
            <div class="row">
                <div class="number" @click="inputEnabled && addNumber(4)">4</div>
                <div class="number" @click="inputEnabled && addNumber(5)">5</div>
                <div class="number" @click="inputEnabled && addNumber(6)">6</div>
            </div>
            <div class="row">
                <div class="number" @click="inputEnabled && addNumber(7)">7</div>
                <div class="number" @click="inputEnabled &&addNumber(8)">8</div>
                <div class="number" @click="inputEnabled && addNumber(9)">9</div>
            </div>
            <div class="row">
                <div class="number" @click="inputEnabled && addNumber(0)">0</div>
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
        width: 7rem;
        height: 7rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin: 0 0.5rem;
        cursor: pointer;
        transition: background-color 0.3s, transform 0.1s;
    }

    @keyframes shake {
      0% { transform: translate(-50%, -50%) translateX(0); }
      20% { transform: translate(-50%, -50%) translateX(-10px); }
      40% { transform: translate(-50%, -50%) translateX(10px); }
      60% { transform: translate(-50%, -50%) translateX(-10px); }
      80% { transform: translate(-50%, -50%) translateX(10px); }
      100% { transform: translate(-50%, -50%) translateX(0); }
    }
    .shake {
      border: 2px solid #e3342f;
      animation: shake 0.4s;
    }
</style>
