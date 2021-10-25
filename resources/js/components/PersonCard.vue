<template>
  <div
    class="bg-gray-100 border-gray-500 dark:bg-gray-800 dark:border-gray-900 border-2 w-full rounded-lg p-3 flex flex-col gap-2"
    :class="borderColor">
      <img :src="(person.img ? person.img : '/images/default.jpg')" class="w-full rounded-lg flex-grow" loading="lazy" />
      <div>
        <h1 class="text-lg text-center">{{ person.firstname }}</h1>
        <h1 class="text-lg text-center">{{ person.lastname }}</h1>
      </div>
      <div class="flex gap-2 justify-center">
        <PersonBadge v-if="person.course == 'INF'" bgColor="bg-blue-500" :icon="['fas', 'code']" />
        <PersonBadge v-if="person.course == 'ET'" bgColor="bg-yellow-500" :icon="['fas', 'bolt']" />
        <PersonBadge v-if="person.course == 'WI'" bgColor="bg-green-500" :icon="['fas', 'chart-line']" />
        <PersonBadge v-if="person.course == 'MCD'" bgColor="bg-purple-500" :icon="['fas', 'paint-brush']" />
        <PersonBadge v-if="person.is_tutor" bgColor="bg-indigo-500" :icon="['fas', 'robot']" />
        <PersonBadge v-if="person.is_special" bgColor="bg-pink-500" :icon="['fas', 'star']" />
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