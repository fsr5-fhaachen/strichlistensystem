<template>
  <div
    class="bg-gray-100 border-2 border-gray-500 w-full rounded-lg p-3 flex flex-col gap-2"
    :class="borderColor">
      <img v-if="user.img" :src="user.img" class="w-full rounded-lg" />
      <h1 class="text-lg text-center">{{ user.firstName }} {{ user.lastName }}</h1>
      <div class="flex gap-2 justify-center">
        <UserBadge v-if="user.course == 'INF'" color="blue" :icon="['fas', 'code']" />
        <UserBadge v-if="user.course == 'ET'" color="yellow" :icon="['fas', 'bolt']" />
        <UserBadge v-if="user.course == 'WI'" color="green" :icon="['fas', 'chart-line']" />
        <UserBadge v-if="user.course == 'MCD'" color="purple" :icon="['fas', 'paint-brush']" />
        <UserBadge v-if="user.isTutor" color="indigo" :icon="['fas', 'robot']" />
        <UserBadge v-if="user.isSpecial" color="pink" :icon="['fas', 'star']" />
      </div>
  </div>
</template>

<script>
import { computed, defineComponent } from "vue";
import UserBadge from "./UserBadge.vue";

export default defineComponent({
  name: "UserCard",
  components: {
    UserBadge,
  },
  props: {
    user: {
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
      if (props.user.isSpecial) {
        return 'hover:border-pink-700';
      } else if (props.user.isTutor) {
        return 'hover:border-indigo-700';
      } else if (props.user.course == 'INF') {
        return 'hover:border-blue-700';
      } else if (props.user.course == 'ET') {
        return 'hover:border-yellow-700';
      } else if (props.user.course == 'WI') {
        return 'hover:border-green-700';
      } else if (props.user.course == 'MCD') {
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