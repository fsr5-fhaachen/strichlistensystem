<template>
  <LayoutContainer>
    <p class="col-span-4 text-center text-red-700 text-2xl">
      Du hast keine Berechtigung für diese Anfrage
    </p>
  </LayoutContainer>
</template>
<script>
import { defineComponent } from "vue";
import LayoutContainer from "../../components/LayoutContainer.vue";

export default defineComponent({
  name: "Error",
  components: {
    LayoutContainer,
  },
});
</script>

<style>

</style>