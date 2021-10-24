<template>
  <LayoutContainer>
    <p class="col-span-4 text-center text-green-700 text-2xl">
      Du wurdest erfolgreich ausgeloggt.
    </p>
  </LayoutContainer>
</template>
<script>
import { defineComponent } from "vue";
import LayoutContainer from "../../components/LayoutContainer.vue";

export default defineComponent({
  name: "Logout",
  components: {
    LayoutContainer,
  },
});
</script>

<style>

</style>