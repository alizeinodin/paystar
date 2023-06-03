<template>
    <div id="app">
        <Navbar></Navbar>
        <router-view></router-view>
    </div>
</template>

<script>
import Navbar from './components/Navbar.vue'

export default {
    name: "App",
    components: {
        Navbar,
    }
}
</script>

<style>
#app {
    font-family: 'IRANSans', Helvetica, Arial, sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    text-align: center;
    color: #2c3e50;
    margin-top: 60px;
}
@font-face {
    font-family: IRANSans;
    font-weight: normal;
    src: url("./fonts/eot/IRANSansWeb.eot") format("embedded-opentype"),
    url("./fonts/ttf/IRANSansWeb.ttf") format("truetype"),
    url("./fonts/woff/IRANSansWeb.woff") format("woff");
}
</style>
