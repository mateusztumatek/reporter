<template>
  <v-app id="inspire" class="app dashboard">
    <app-drawer class="app--drawer" :show-drawer="showDrawer"></app-drawer>
    <app-toolbar class="app--toolbar" @side-icon-click="handleDrawerVisiable"></app-toolbar>
    <v-content>
      <!-- Page Header -->
      <page-header></page-header>
      <div class="page-wrapper">
        <transition name="fade-in" mode="out-in">
          <router-view :key="key"></router-view>
        </transition>
      </div>
      <!-- App Footer -->
      <v-footer height="auto" class="white pa-3 app--footer">
        <span class="caption">isocked.com Design &copy; {{ new Date().getFullYear() }}</span>
        <v-spacer></v-spacer>
        <span class="caption mr-1"> Make With Love </span>
        <v-icon color="pink" small>favorite</v-icon>
      </v-footer>
      <message-component></message-component>

    </v-content>
    <!-- Go to top -->
    <app-fab></app-fab>
  </v-app>
</template>

<script>
import AppDrawer from "@/components/AppDrawer"
import AppToolbar from "@/components/AppToolbar"
import AppFab from "@/components/AppFab"
import PageHeader from "@/components/PageHeader"
import MessageComponent from '@/components/messages-component';
export default {
  components: {
    MessageComponent,
    AppDrawer,
    AppToolbar,
    AppFab,
    PageHeader
  },
  computed:{
    key(){
      return this.$route.fullPath;
    }
  },
  data() {
    return {
      showDrawer: true
    }
  },
  methods: {
    handleDrawerVisiable() {
      this.showDrawer = !this.showDrawer
    }
  },
  created() {}
}
</script>

<style scoped>
  @import "../../theme/default.scss";
.page-wrapper {
  min-height: calc(100vh - 64px - 50px - 81px);
}
</style>
