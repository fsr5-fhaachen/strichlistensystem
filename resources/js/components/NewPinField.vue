<script setup>

import PinInput from "@/components/PinInput.vue";
import {ref} from "vue";

const clearPin = ref(false);
const statusText = ref(["Neue Pin eingeben", "Neue Pin erneut eingeben"])
const status = ref(0)
const pins = ref(["",""])

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
            emit('redirectToUser');
        }
    }
}

</script>

<template>
    <PinInput :clearPinTask="clearPin"
              @closeEarly="emit('closeNewPinFieldEarly')"
              @pinComplete="validatePin"
    >{{statusText[status]}}</PinInput>
</template>

<style scoped>

</style>
