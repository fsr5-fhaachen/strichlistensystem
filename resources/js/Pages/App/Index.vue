<template>
  <LayoutContainer>
    <div class="flex flex-wrap gap-4 justify-center md:col-span-2 lg:col-span-4" >
      <AppButton title="Alle" color="gray" :icon="['fas', 'users']" :active="filter == 'all'" @click="filter = 'all'"/>
      <AppButton title="INF" color="blue" :icon="['fas', 'code']" :active="filter == 'inf'" @click="filter = 'inf'"/>
      <AppButton title="ET" color="yellow" :icon="['fas', 'bolt']" :active="filter == 'et'" @click="filter = 'et'"/>
      <AppButton title="WI" color="green" :icon="['fas', 'chart-line']" :active="filter == 'wi'" @click="filter = 'wi'"/>
      <AppButton title="MCD" color="purple" :icon="['fas', 'paint-brush']" :active="filter == 'mcd'" @click="filter = 'mcd'"/>
      <AppButton title="Tutor" color="indigo" :icon="['fas', 'robot']" :active="filter == 'tutor'" @click="filter = 'tutor'"/>
      <AppButton title="Special" color="pink" :icon="['fas', 'star']" :active="filter == 'special'" @click="filter = 'special'"/>
    </div>
    <div class="grid gap-4 grid-cols-2 sm:grid-cols-3 md:col-span-2 md:grid-cols-4 lg:col-span-4 lg:grid-cols-5 xl:grid-cols-6 2xl:grid-cols-8"> 
      <Link
        v-for="person in filteredPersons"
        :key="person.id"
        :href="'/person/' + person.id + '/'">
        <PersonCard
          :person="person"
          class="h-full"
        />
      </Link>
    </div>
  </LayoutContainer>
</template>
<script>
import { computed, defineComponent, ref } from "vue";
import { Link } from '@inertiajs/inertia-vue3'
import AppButton from "../../components/AppButton.vue";
import LayoutContainer from "../../components/LayoutContainer.vue";
import PersonCard from "../../components/PersonCard.vue";

export default defineComponent({
  name: "Index",
  components: {
    AppButton,
    LayoutContainer,
    Link,
    PersonCard,
  },
  props: {
    persons: {
      type: Array,
      required: true,
    },
  },
  setup(props) {
    var filter = ref("all");
    
    var filteredPersons = computed(() => {
      if (filter.value === "all") {
        return props.persons;
      }
      return props.persons.filter((person) => {
        if(filter.value === "inf") {
          return person.course === "INF";
        } else if(filter.value === "et") {
          return person.course === "ET";
        } else if(filter.value === "wi") {
          return person.course === "WI";
        } else if(filter.value === "mcd") {
          return person.course === "MCD";
        } else if(filter.value === "tutor") {
          return person.is_tutor;
        } else if(filter.value === "special") {
          return person.is_special;
        }
      });
    });


    return {
      filter,
      filteredPersons,
    };
  },
});
</script>

<style>

</style>