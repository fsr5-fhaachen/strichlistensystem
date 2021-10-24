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
      <ArticleCard
        v-for="article in articles"
        :article="article"
        @click="buy(article)"
      />
    </div>    
    <div class="col-span-4 bg-gray-100 border-2 border-gray-500 rounded-lg p-3"> 
      <h1 class="text-2xl mb-4">Deine letzten 20 Aktivitäten</h1>
      <ul v-if="articleActionLogs" class="flex flex-col gap-3">
        <li v-for="articleActionLog in articleActionLogs" :key="articleActionLog.id" class="flex gap-2 items-center">
          <span class="text-gray-600 font-bold w-56">{{ articleActionLog.createdAtFormatted }}</span>
          <span v-if="articleActionLog.deleted_at" class="text-lg text-red-800">
            Du hast den Artikel "<span class="font-bold">{{ articleActionLog.article.name }}</span>" am <span class="font-bold">{{ articleActionLog.deletedAtFormatted }}</span> storniert.
          </span>
          <span v-else class="text-lg text-green-600">
            Du hast den Artikel "<span class="font-bold">{{ articleActionLog.article.name }}</span>" gekauft.
          </span>
          <a v-if="!articleActionLog.deleted_at && articleActionLog.cancelUntilTimestamp * 1000 >= Date.now()" class="text-red-700 uppercase font-bold text-lg cursor-pointer" @click="cancel(articleActionLog)">[stornieren]</a>
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
import ArticleCard from "../../components/ArticleCard.vue";

export default defineComponent({
  name: "Index",
  components: {
    AppButton,
    LayoutContainer,
    Link,
    PersonCard,
    ArticleCard,
  },
  props: {
    person: {
      type: Object,
      required: true,
    },
    articles: {
      type: Array,
      required: true,
    },
    articleActionLogs: {
      type: Array,
      required: true,
    },
  },
  setup(props) {
    const redirectCountdown = ref(20);

    const buy = (article) => {
      redirectCountdown.value = 20;
      Inertia.post('/person/' + props.person.id + '/buy/' + article.id, null, {
        preserveScroll: true,
      });
    }

    const cancel = (articleActionLog) => {
      redirectCountdown.value = 20;
      Inertia.post('/person/' + props.person.id + '/cancel/' + articleActionLog.id, null, {
        preserveScroll: true,
      });
    }

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
      buy,
      cancel,
      redirectCountdown,
    };
  }
});
</script>

<style>

</style>