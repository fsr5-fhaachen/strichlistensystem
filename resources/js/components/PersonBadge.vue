<template>
  <div
    class="flex justify-center items-center p-2 text-white font-semibold rounded-full shadow-md h-10 w-10" 
    :class="bgColor">
    <font-awesome-icon
      :icon="icon"
    />
  </div>
</template>

<script>
import { computed, defineComponent } from "vue";

export default defineComponent({
  name: "PersonBadge",
  props: {
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
      return `bg-${props.color}-500`;
    });

    return {
      bgColor
    };
  }
});
</script>

<style>

</style>