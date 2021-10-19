<template>
  <button
    class="py-2 px-4 flex gap-2 justify-center items-center text-white font-semibold rounded-lg shadow-md focus:outline-none"
    :class="bgColor"
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
    color: {
      type: String,
      default: "gray"
    },
    icon: {
      type: Array,
    }
  },
  setup(props) {
    const bgColor = computed(() => {
      return `bg-${props.color}-500 hover:bg-${props.color}-700 `;
    });

    return {
      bgColor
    };
  }
});
</script>

<style>

</style>