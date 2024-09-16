<template>
  <div class="bg-gray-100 border-gray-500 dark:bg-gray-800 dark:border-gray-900 border-2 w-full rounded-lg p-8 gap-8 cursor-pointer flex flex-col">
    <div class="flex items-center gap-8">
      <font-awesome-icon class="text-4xl md:text-6xl" v-if="article.icon" :icon="['fas', article.icon]" />
      <h1 class="text-2xl md:text-4xl text-center">{{ article.name }}</h1>
    </div>
   
    <div class="flex gap-8 justify-center">
      <button @click="removeAmount" :disabled="amount <= 1" class="text-2xl md:text-4xl">
        -
      </button>

      <div class="text-2xl md:text-4xl">
        {{ amount }}
      </div>

      <button  @click="addAmount" :disabled="amount >= maxAmount"  class="text-2xl md:text-4xl">
        +
      </button>
    </div>
    <button class="
    bg-green-500
    dark:bg-green-700 
    hover:bg-green-700
    dark:hover:bg-green-900 
      px-4 py-2 text-2xl md:text-4x rounded-lg
      disabled:opacity-10"
      @click="buy"
      :disabled="disabled">
      BUCHEN!
    </button>
  </div>
</template>

<script>
import { defineComponent, ref } from "vue";

// nach buy, 3 sekunden cooldown (ausgeraut)

export default defineComponent({
  name: "ArticleCard",
  props: {
    article: {
      type: Object,
      required: true
    },
  },
  emits: ['submit'],
  setup(props, ctx) {
    const amount = ref(1);
    const maxAmount = parseInt(process.env.MIX_APP_MAX_ORDER_COUNT);
    const disabled = ref(false);
    const timeoutSeconds = 3;

    const addAmount = () => {
      if( amount.value >= maxAmount) {
        return;
      }
      amount.value++;
    };

    const removeAmount = () => {
      if( amount.value <= 1) {
        return;
      }
      amount.value--;
    };

    const buy = () => {
      disabled.value = true;
      ctx.emit('submit', props.article, amount.value);
      amount.value = 1;
      
      setTimeout(() => {
        disabled.value = false;
      }, timeoutSeconds * 1000);
    }

    return {
      maxAmount,
      amount,
      disabled,
      addAmount,
      removeAmount,
      buy,
    }
  },
});
</script>

<style>

</style>
