<script setup>

import PinInput from "@/components/PinInput.vue";
import {ref} from "vue";
import axios from "axios";
import Cookies from "js-cookie";

const clearPin = ref(false);
const statusText = ref(["Neue Pin eingeben", "Neue Pin erneut eingeben"])
const status = ref(0)
const pins = ref(["",""])
const props = defineProps({
    id: {
        type: Number || null,
        required: true
    }
});

const emit = defineEmits(["closeNewPinFieldEarly","redirectToUser"]);

function validatePin(completePin) {
    if (status.value === 0){
        pins.value[0] = completePin;
        status.value = 1;
        clearPin.value = true;
    }
    else {
        pins.value[1] = completePin;
        if (pins.value[0] === pins.value[1]) {
            axios.post("/setPin",{
                id: props.id,
                pin: pins.value[0],
                token: Cookies.get("token")
            },{
                headers: {
                    Authorization: `Bearer ${Cookies.get("token")}`
                }
            })
                .then(response => {
                    switch (response.status){
                        case 200:
                            emit('redirectToUser');
                    }
                })
                .catch(error => {
                    clearPin.value = true;
                });
        }
    }
}

</script>

<template>
    <PinInput :clearPinTask="clearPin"
              :clearPinType="'none'"
              @closeEarly="emit('closeNewPinFieldEarly')"
              @pinComplete="validatePin"
    >{{statusText[status]}}</PinInput>
</template>

<style scoped>

</style>
