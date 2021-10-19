<template>
  <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-4 m-8">
    <slot/>
  </div>
</template>

<script>
import { defineComponent } from "vue";

export default defineComponent({
  name: "LayoutContainer",
});
</script>

<style>

</style>