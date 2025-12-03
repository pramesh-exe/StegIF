
import '@fortawesome/fontawesome-free/css/all.css';
// import { aliases, fa } from 'vuetify/iconsets/fa'
import "vuetify/styles";
import { createVuetify } from "vuetify";
import * as components from "vuetify/components";
import * as directives from "vuetify/directives";

const lightTheme = {
    dark: false,
    colors: {
        background: "#000",
        surface: "#eaeaea",
        primary: "#0e0c69",
        secondary: "#0a0a0a",
        "on-background": "#eaeaea",
        "on-surface": "#0a0a0a",
        "on-primary": "#eaeaea",
        "on-secondary": "#eaeaea",
        "error": "#a11d1d",
    },
};

export default createVuetify({
    components,
    directives,

    // theme: {
    //     defaultTheme: "lightTheme",
    //     themes: {
    //         lightTheme,
    //     },
    // },
    // icons: {
    //     defaultSet: 'fa',
    //     aliases,
    //     sets: {
    //         fa,
    //     },
    // },
});
