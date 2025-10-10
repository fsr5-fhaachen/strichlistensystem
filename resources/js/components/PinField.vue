<script setup>
    const props = defineProps({
        showPinField: {
            type: Boolean,
            required: true
        }
    })
</script>

<template>
    <div class="backGround">
        <div class="pinField">
            <div class="row">
                <div class="number">1</div>
                <div class="number">2</div>
                <div class="number">3</div>
            </div>
            <div class="row">
                <div class="number">4</div>
                <div class="number">5</div>
                <div class="number">6</div>
            </div>
            <div class="row">
                <div class="number">7</div>
                <div class="number">8</div>
                <div class="number">9</div>
            </div>
            <div class="row">
                <div class="number">0</div>
            </div>
            <div class="row">
                <div class="number"></div>
                <div class="number"></div>
                <div class="number"></div>
                <div class="number"></div>
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
