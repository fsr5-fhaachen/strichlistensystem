<template>
    <LayoutContainer>
        <div
            class="flex flex-wrap gap-4 justify-center md:col-span-2 lg:col-span-4"
        >
            <AppButton
                title="Alle"
                bgColor="bg-gray-500 dark:bg-gray-700 hover:bg-gray-700"
                bgColorActive="bg-gray-900"
                :icon="['fas', 'users']"
                :active="filter == 'all'"
                @click="filter = 'all'"
            />
            <AppButton
                title="INF"
                bgColor="bg-blue-500 hover:bg-blue-700"
                bgColorActive="bg-blue-700"
                :icon="['fas', 'code']"
                :active="filter == 'inf'"
                @click="filter = 'inf'"
            />
            <AppButton
                title="ET"
                bgColor="bg-yellow-500 hover:bg-yellow-700"
                bgColorActive="bg-yellow-700"
                :icon="['fas', 'bolt']"
                :active="filter == 'et'"
                @click="filter = 'et'"
            />
            <AppButton
                title="WI"
                bgColor="bg-green-500 hover:bg-green-700"
                bgColorActive="bg-green-700"
                :icon="['fas', 'chart-line']"
                :active="filter == 'wi'"
                @click="filter = 'wi'"
            />
            <AppButton
                title="DIB"
                bgColor="bg-fuchsia-500 hover:bg-fuchsia-700"
                bgColorActive="bg-fuchsia-700"
                :icon="['fas', 'briefcase']"
                :active="filter == 'dib'"
                @click="filter = 'dib'"
            />
            <AppButton
                title="MCD"
                bgColor="bg-purple-500 hover:bg-purple-700"
                bgColorActive="bg-purple-700"
                :icon="['fas', 'paint-brush']"
                :active="filter == 'mcd'"
                @click="filter = 'mcd'"
            />
            <AppButton
                title="Tutor"
                bgColor="bg-indigo-500 hover:bg-indigo-700"
                bgColorActive="bg-indigo-700"
                :icon="['fas', 'robot']"
                :active="filter == 'tutor'"
                @click="filter = 'tutor'"
            />
            <AppButton
                title="Special"
                bgColor="bg-pink-500 hover:bg-pink-700"
                bgColorActive="bg-pink-700"
                :icon="['fas', 'star']"
                :active="filter == 'special'"
                @click="filter = 'special'"
            />
        </div>
        <div
            class="grid gap-4 grid-cols-2 sm:grid-cols-3 md:col-span-2 md:grid-cols-4 lg:col-span-4"
        >
            <Link
                v-for="person in filteredPersons"
                :key="person.id"
                :href="'/person/' + person.id + '/'"
            >
                <PersonCard :person="person" class="h-full" />
            </Link>
        </div>
    </LayoutContainer>
</template>
<script>
import { computed, defineComponent, ref, watch } from "vue";
import { Link } from "@inertiajs/vue3";
import AppButton from "../../components/AppButton.vue";
import LayoutContainer from "../../components/LayoutContainer.vue";
import PersonCard from "../../components/PersonCard.vue";
import NProgress from "nprogress";

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

        watch(filter, (filter, prevFilter) => {
            console.log(filter, prevFilter);
            NProgress.start();
        });

        var filteredPersons = computed(() => {
            if (filter.value === "all") {
                const tmp = props.persons;
                NProgress.done();
                return tmp;
            }
            const tmp = props.persons.filter((person) => {
                if (filter.value === "inf") {
                    return person.course === "INF";
                } else if (filter.value === "et") {
                    return person.course === "ET";
                } else if (filter.value === "wi") {
                    return person.course === "WI";
                } else if (filter.value === "dib") {
                    return person.course === "DIB";
                } else if (filter.value === "mcd") {
                    return person.course === "MCD";
                } else if (filter.value === "tutor") {
                    return person.is_tutor;
                } else if (filter.value === "special") {
                    return person.is_special;
                }
            });
            NProgress.done();
            return tmp;
        });

        return {
            filter,
            filteredPersons,
        };
    },
});
</script>

<style></style>
