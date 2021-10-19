<template>
  <LayoutContainer>
    <div class="flex gap-4 justify-center md:col-span-2 lg:col-span-4" >
      <AppButton title="Alle" color="gray" :icon="['fas', 'users']" />
      <AppButton title="INF" color="blue" :icon="['fas', 'code']" />
      <AppButton title="ET" color="yellow" :icon="['fas', 'bolt']" />
      <AppButton title="WI" color="green" :icon="['fas', 'chart-line']" />
      <AppButton title="MCD" color="purple" :icon="['fas', 'paint-brush']" />
      <AppButton title="Tutor" color="indigo" :icon="['fas', 'robot']" />
      <AppButton title="Special" color="pink" :icon="['fas', 'star']" />
    </div>
  </LayoutContainer>
</template>
<script>
import { defineComponent } from "vue";
import AppButton from "../../components/AppButton.vue";
import LayoutContainer from "../../components/LayoutContainer.vue";

export default defineComponent({
    name: "Index",
    components: {
      AppButton,
      LayoutContainer,
    }
});
</script>

<style>

</style>