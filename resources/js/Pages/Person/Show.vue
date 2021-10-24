<template>
  <LayoutContainer>
    <div class="flex flex-wrap gap-4 justify-center md:col-span-2 lg:col-span-4" >
      <Link href="/">
        <AppButton title="Zurück zur Übersicht" color="gray" :icon="['fas', 'arrow-left']" />
      </Link>
      <AppButton title="QR-Code erstellen" color="blue" :icon="['fas', 'qrcode']" />
    </div>
    <p class="col-span-4 text-center text-red-700 text-2xl">
      Du wirst in 
      <template v-if="redirectCountdown == 1">
        einer Sekunde
      </template>
      <template v-else>
        {{ redirectCountdown }} Sekunden
      </template>
       auf die Startseite geleitet.
      </p>
    <div class="grid gap-4 col-span-4 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-5"> 
      <PersonCard
        :canBeHovered="false"
        :person="person"
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
    <div class="col-span-4 bg-gray-100 border-2 border-gray-500 rounded-lg p-3"> 
      <h1 class="text-2xl mb-4">Deine letzten 20 Aktivitäten</h1>
      <ul class="flex flex-col gap-3">
        <li class="flex gap-2 items-center">
          <span class="text-gray-600 font-bold w-44">23.10.2021 23:14 Uhr</span>
          <span class="text-green-800 text-lg">Du hast den Artikel "XXX" gekauft.</span>
          <a class="text-red-700 uppercase font-bold text-lg cursor-pointer">[stornieren]</a>
        </li>
        <li class="flex gap-2 items-center">
          <span class="text-gray-600 font-bold w-44">23.10.2021 23:11 Uhr</span>
          <span class="text-red-800 text-lg">Du hast den Artikel "XXX" storniert.</span>
        </li>
        <li class="flex gap-2 items-center">
          <span class="text-gray-600 font-bold w-44">23.10.2021 23:11 Uhr</span>
          <span class="text-green-800 text-lg">Du hast den Artikel "XXX" gekauft.</span>
        </li>
        <li class="flex gap-2 items-center">
          <span class="text-gray-600 font-bold w-44">23.10.2021 15:54 Uhr</span>
          <span class="text-green-800 text-lg">Du hast den Artikel "XXX" gekauft.</span>
        </li>
        <li class="flex gap-2 items-center">
          <span class="text-gray-600 font-bold w-44">23.10.2021 12:32 Uhr</span>
          <span class="text-green-800 text-lg">Du hast den Artikel "XXX" gekauft.</span>
        </li>
      </ul>
    </div>
  </LayoutContainer>
</template>

<script>
import { defineComponent, ref } from "vue";
import { Inertia } from '@inertiajs/inertia'
import { Link } from '@inertiajs/inertia-vue3'
import AppButton from "../../components/AppButton.vue";
import LayoutContainer from "../../components/LayoutContainer.vue";
import PersonCard from "../../components/PersonCard.vue";
import ItemCard from "../../components/ItemCard.vue";

export default defineComponent({
  name: "Index",
  components: {
    AppButton,
    LayoutContainer,
    Link,
    PersonCard,
    ItemCard,
  },
  props: {
    person: {
      type: Object,
      required: true,
    },
  },
  setup() {
    const redirectCountdown = ref(50);

    const countdown = () => {
      if (redirectCountdown.value > 1) {
        redirectCountdown.value--;
        setTimeout(countdown, 1000);
      } else {
        Inertia.visit('/')
      }
    };

    countdown();

    return {
      redirectCountdown,
    };
  }
});
</script>

<style>

</style>