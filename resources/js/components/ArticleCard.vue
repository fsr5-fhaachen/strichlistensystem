<template>
  <div class="bg-gray-100 border-gray-500 dark:bg-gray-800 dark:border-gray-900 border-2 w-full rounded-lg p-8 flex flex-col gap-8 justify-center hover:bg-green-300 hover:border-green-800 dark:hover:bg-green-500  cursor-pointer">
    <div class="text-center">
      <font-awesome-icon class="text-9xl" v-if="article.icon" :icon="['fas', article.icon]" />
    </div>
    <h1 class="text-4xl text-center">{{ article.name }}</h1>
  </div>
</template>

<script>
import { computed, defineComponent } from "vue";

export default defineComponent({
  name: "ArticleCard",
  props: {
    article: {
      type: Object,
      required: true
    },
  },
});
</script>

<style>

</style>