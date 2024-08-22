<template>
  <div ref="target">
    <img v-if="targetWasVisibleOnce" :src="imageUrl" class="w-full rounded-lg" loading="lazy" />
    <div v-else class="w-full rounded-lg h-52 bg-gray-900 animate-pulse" ></div>
  </div>
</template>

<script>
import { defineComponent, ref, watch } from "vue";
import { useElementVisibility } from "@vueuse/core";

export default defineComponent({
  name: "PersonAvatar",
  props: {
    person: {
      type: Object,
      required: true
    }
  },
  setup(props) {
    const target = ref(null);
    const targetIsVisible = useElementVisibility(target);
    const targetWasVisibleOnce = ref(false);
    const imageUrl = ref(null);

    watch(targetIsVisible, () => {
      if (!targetWasVisibleOnce.value && targetIsVisible) {
        console.log("Avatar of person " + props.person.id + " is visible for the first time.");

        targetWasVisibleOnce.value = true;

        // get image from backend for current person object (can be presigned url or path to default image)
        imageUrl.value = props.person.image;
      }
    });

    return {
      target,
      targetIsVisible,
      targetWasVisibleOnce,
      imageUrl
    };
  }
});
</script>

<style>

</style>
