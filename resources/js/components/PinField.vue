<script setup>
import { ref, defineProps } from "vue";
import axios from "axios";
import Cookies from "js-cookie";
import PinInput from "@/components/PinInput.vue";

const isShaking = ref(false);
const clearPin = ref(false);

const props = defineProps({
    id: {
        type: Number || null,
        required: true,
    },
});

const emit = defineEmits([
    "closePinFieldEarly",
    "newPinRequired",
    "redirectToUser",
]);

function validatePin(completePin) {
    axios
        .post("/checkPin", {
            pin: completePin,
            user: props.id,
        })
        .then((response) => {
            switch (response.status) {
                case 200:
                    Cookies.set("token", response.headers["token"]);
                    if (response.data.pin_change_required) {
                        emit("newPinRequired");
                    } else {
                        emit("redirectToUser");
                    }
            }
        })
        .catch((error) => {
            clearPin.value = true;
        });
}
</script>

<template>
    <PinInput
        :id="props.id"
        :clearPinTask="clearPin"
        :clearPinType="'error'"
        @pinComplete="validatePin"
        @closeEarly="emit('closePinFieldEarly')"
        @pinCleared="clearPin = false"
        >Pin eingeben</PinInput
    >
</template>

<style scoped></style>
