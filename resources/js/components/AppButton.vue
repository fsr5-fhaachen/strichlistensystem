<template>
  <button
    class="py-2 px-4 flex gap-2 justify-center items-center text-lg text-white font-semibold rounded-lg shadow-md focus:outline-none"
    :class="(active ? bgColorActive : bgColor)"
  >
    <font-awesome-icon v-if="icon" :icon="icon" />
    <span>{{ title }}</span>
  </button>
</template>

<script>
import { computed, defineComponent } from "vue";

export default defineComponent({
  name: "AppButton",
  props: {
    title: {
      type: String,
      required: true
    },
    bgColor: {
      type: String,
      default: "bg-gray-500 hover:bg-gray-700"
    },
    bgColorActive: {
      type: String,
      default: "bg-gray-700"
    },
    icon: {
      type: Array,
    },
    active: {
      type: Boolean,
      default: false
    }
  },
});
</script>

<style>

</style>