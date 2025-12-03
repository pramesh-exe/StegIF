import { createRouter, createWebHistory } from "vue-router";
import Home from "../views/Home.vue";
import Story from "../views/Story.vue";
import Game from "../views/Game.vue";
import SteganographyText from "../views/SteganographyText.vue";
import PageNotFound from "../views/404.vue";
import ExtraInfo from "../components/textboxes/ExtraInfo.vue";
import KnowledgeTest from "../components/textboxes/KnowledgeTest.vue";

const routes = [
    // {
    //     path: "/",
    //     name: "Home",
    //     component: Home,
    // },
    {
        path: "/story",
        name: "Story",
        component: Story,
    },
    {
        path: "/",
        name: "Game",
        component: Game,
        props: {
            experimentState: 0,
            participantId: "0",
            saveResults: false,
        },
    },
    // {
    //     path: "/text",
    //     name: "Text",
    //     component: SteganographyText,
    // },
    // {
    //     path: "/test",
    //     name: "Test",
    //     component: KnowledgeTest,
    // },
    // {
    //     path: "/extra-info",
    //     name: "Extra Information",
    //     component: ExtraInfo,
    // },
    {
        path: "/:pathMatch(.*)*",
        name: "404 - Page not found",
        component: PageNotFound,
    },
];

export default createRouter({
    history: createWebHistory(),
    routes,
});
