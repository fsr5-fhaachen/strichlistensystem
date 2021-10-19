<template>
  <LayoutContainer>
    <div class="flex flex-wrap gap-4 justify-center md:col-span-2 lg:col-span-4" >
      <AppButton title="Alle" color="gray" :icon="['fas', 'users']" />
      <AppButton title="INF" color="blue" :icon="['fas', 'code']" />
      <AppButton title="ET" color="yellow" :icon="['fas', 'bolt']" />
      <AppButton title="WI" color="green" :icon="['fas', 'chart-line']" />
      <AppButton title="MCD" color="purple" :icon="['fas', 'paint-brush']" />
      <AppButton title="Tutor" color="indigo" :icon="['fas', 'robot']" />
      <AppButton title="Special" color="pink" :icon="['fas', 'star']" />
    </div>
    <div class="grid gap-4 grid-cols-2 sm:grid-cols-3 md:col-span-2 md:grid-cols-4 lg:col-span-4 lg:grid-cols-5 xl:grid-cols-6 2xl:grid-cols-8"> 
      <UserCard
        :user="{
          firstName: 'Max',
          lastName: 'Mustermann',
          course: 'INF',
          img: 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
          isTutor: true,
          isSpecial: true,
        }"
      />
      <UserCard
        :user="{
          firstName: 'Max',
          lastName: 'Mustermann',
          course: 'INF',
          img: 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
          isTutor: true,
          isSpecial: false,
        }"
      />
      <UserCard
        :user="{
          firstName: 'Max',
          lastName: 'Mustermann',
          course: 'INF',
          img: 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
          isTutor: false,
          isSpecial: false,
        }"
      />
      <UserCard
        :user="{
          firstName: 'Max',
          lastName: 'Mustermann',
          course: 'ET',
          img: 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
          isTutor: false,
          isSpecial: false,
        }"
      />
      <UserCard
        :user="{
          firstName: 'Max',
          lastName: 'Mustermann',
          course: 'WI',
          img: 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
          isTutor: false,
          isSpecial: false,
        }"
      />
      <UserCard
        :user="{
          firstName: 'Max',
          lastName: 'Mustermann',
          course: 'MCD',
          img: 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
          isTutor: false,
          isSpecial: false,
        }"
      />
    </div>
  </LayoutContainer>
</template>
<script>
import { defineComponent } from "vue";
import AppButton from "../../components/AppButton.vue";
import LayoutContainer from "../../components/LayoutContainer.vue";
import UserCard from "../../components/UserCard.vue";

export default defineComponent({
  name: "Index",
  components: {
    AppButton,
    LayoutContainer,
    UserCard,
  }
});
</script>

<style>

</style>