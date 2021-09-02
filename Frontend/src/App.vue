<template>
    <div id="app" class="container" v-cloak>
        <img id="logo" src="./assets/logo.png" class="logo">
        <router-view></router-view>
    </div>
</template>

<script>

import OrganisationList from './components/OrganisationsList'
import CreateOrganisation from './components/CreateOrganisation'
import Login from './components/Login'
import NotFound from './components/NotFound'

export default {
    name: 'App',
    components: {
        OrganisationList,
        CreateOrganisation,
        Login,
        NotFound
    }
}
</script>

<style>

[v-cloak] {
    display: none;
}

* {
    box-sizing: border-box;
}

.container {
    max-width: 900px;
    margin: 0 auto;
}

#app {
    font-family: 'Avenir', Helvetica, Arial, sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    color: #2c3e50;
    margin-top: 60px;
}

.logo {
    display: block;
    margin: 20px auto;
    height: 75px;
}

</style>
