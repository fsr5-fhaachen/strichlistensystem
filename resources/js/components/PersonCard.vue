<template>
  <div
    class="bg-gray-100 border-gray-500 dark:bg-gray-800 dark:border-gray-900 border-2 w-full rounded-lg p-3 flex flex-col gap-2"
    :class="borderColor">
      <img :src="(person.img ? person.img : '/images/default.png')" class="w-full rounded-lg flex-grow" loading="lazy" />
      <h1 class="text-lg text-center">{{ person.firstname }} {{ person.lastname }}</h1>
      <div class="flex gap-2 justify-center">
        <PersonBadge v-if="person.course == 'INF'" color="blue" :icon="['fas', 'code']" />
        <PersonBadge v-if="person.course == 'ET'" color="yellow" :icon="['fas', 'bolt']" />
        <PersonBadge v-if="person.course == 'WI'" color="green" :icon="['fas', 'chart-line']" />
        <PersonBadge v-if="person.course == 'MCD'" color="purple" :icon="['fas', 'paint-brush']" />
        <PersonBadge v-if="person.is_tutor" color="indigo" :icon="['fas', 'robot']" />
        <PersonBadge v-if="person.is_special" color="pink" :icon="['fas', 'star']" />
      </div>
  </div>
</template>

<script>
import { computed, defineComponent } from "vue";
import PersonBadge from "./PersonBadge.vue";

export default defineComponent({
  name: "PersonCard",
  components: {
    PersonBadge,
  },
  props: {
    person: {
      type: Object,
      required: true
    },
    canBeHovered: {
      type: Boolean,
      default: true
    }
  },
  setup(props) {
    const borderColor = computed(() => {
      if(!props.canBeHovered) {
        return '';
      }
      if (props.person.is_special) {
        return 'hover:border-pink-700';
      } else if (props.person.is_tutor) {
        return 'hover:border-indigo-700';
      } else if (props.person.course == 'INF') {
        return 'hover:border-blue-700';
      } else if (props.person.course == 'ET') {
        return 'hover:border-yellow-700';
      } else if (props.person.course == 'WI') {
        return 'hover:border-green-700';
      } else if (props.person.course == 'MCD') {
        return 'hover:border-purple-700';
      } else {
        return 'hover:border-gray-700';
      }
    });

    return {
      borderColor
    };
  }
});
</script>

<style>

</style>