<template>
  <LayoutContainer>
    <div class="flex flex-wrap gap-4 justify-center md:col-span-2 lg:col-span-4" >
      <Link href="/">
        <AppButton title="Zurück zur Übersicht" color="gray" :icon="['fas', 'arrow-left']" />
      </Link>
      <AppButton title="QR-Code erstellen" color="blue" :icon="['fas', 'qrcode']" />
    </div>
    <div class="grid gap-4 col-span-4 grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6"> 
      <UserCard
        :canBeHovered="false"
        :user="user"
      />
      <ItemCard
        :item="{
          id: 1,
          title: 'Bier',
          icon: ['fas', 'beer'],
        }"
      />
      <ItemCard
        :item="{
          id: 2,
          title: 'Radler',
          icon: ['fas', 'lemon'],
        }"
      />
      <ItemCard
        :item="{
          id: 1,
          title: 'Softdrinks',
          icon: ['fas', 'wine-bottle'],
        }"
      />
      <ItemCard
        :item="{
          id: 1,
          title: 'Wasser',
          icon: ['fas', 'faucet'],
        }"
      />
    </div>
  </LayoutContainer>
</template>
<script>
import { defineComponent } from "vue";
import { Link } from '@inertiajs/inertia-vue3'
import AppButton from "../../components/AppButton.vue";
import LayoutContainer from "../../components/LayoutContainer.vue";
import UserCard from "../../components/UserCard.vue";
import ItemCard from "../../components/ItemCard.vue";

export default defineComponent({
  name: "Index",
  components: {
    AppButton,
    LayoutContainer,
    Link,
    UserCard,
    ItemCard,
  },
  props: {
    user: {
      type: Object,
      required: true,
    },
  },
  setup() {
    
  }
});
</script>

<style>

</style>