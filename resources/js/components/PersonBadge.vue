<template>
  <div
    class="flex justify-center items-center p-2 text-gray-200 font-semibold rounded-full shadow-md h-10 w-10" 
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
    bgColor: {
      type: String,
      default: "bg-gray-500"
    },
    icon: {
      type: Array,
    }
  },
});
</script>

<style>

</style>