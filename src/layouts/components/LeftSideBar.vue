<template>
  <div class="left-drawer">
    <q-drawer
      :width="
        $q.screen.width < 768
          ? 324
          : $q.screen.width === 768
          ? 61
          : $q.screen.width > 1919
          ? 106
          : 75
      "
      show-if-above
      :behavior="$q.screen.width < 768 ? 'mobile' : 'desktop'"
      v-model="leftDrawerOpen"
    >
      <!-- Tablet to Laptop Devices -->
      <div
        class="side-nav enrollment-bg-primary gt-xs"
        v-if="$q.screen.width >= 768"
      >
        <div class="nav-body">
          <div class="logo">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="40"
              height="40"
              viewBox="0 0 24 24"
              style="margin-left: 15px"
            >
              <g
                fill="none"
                stroke="orange"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="1.5"
              >
                <path
                  d="M7.4 7H4.6a.6.6 0 0 0-.6.6v8.8a.6.6 0 0 0 .6.6h2.8a.6.6 0 0 0 .6-.6V7.6a.6.6 0 0 0-.6-.6Zm12 0h-2.8a.6.6 0 0 0-.6.6v8.8a.6.6 0 0 0 .6.6h2.8a.6.6 0 0 0 .6-.6V7.6a.6.6 0 0 0-.6-.6Z"
                />
                <path
                  d="M1 14.4V9.6a.6.6 0 0 1 .6-.6h1.8a.6.6 0 0 1 .6.6v4.8a.6.6 0 0 1-.6.6H1.6a.6.6 0 0 1-.6-.6Zm22 0V9.6a.6.6 0 0 0-.6-.6h-1.8a.6.6 0 0 0-.6.6v4.8a.6.6 0 0 0 .6.6h1.8a.6.6 0 0 0 .6-.6ZM8 12h8"
                />
              </g>
            </svg>
          </div>
          <div class="btnGroup">
            <q-btn
              :to="{ name: 'home' }"
              flat
              icon="iconfont icon-home-fill"
              class="btnHome enrollment-text-primary"
            />
            <q-btn
              v-if="$q.screen.width > 1023"
              @click="ToggleMenuBtnState()"
              flat
              icon="iconfont icon-burger-menu-line"
              class="btnMenu"
            />
            <q-btn
              v-else
              @click="ToggleLeftDrawer()"
              flat
              icon="iconfont icon-burger-menu-line"
              class="btnMenu"
            />
            <div class="lblMenu enrollment-text-primary">menu</div>
          </div>
        </div>
      </div>
    </q-drawer>
  </div>
</template>

<script>
import { useQuasar } from "quasar";
import { ToggleLeftDrawer, ToggleMenuBtnState } from "src/composables/Triggers";
// import { IsAllowed } from "src/composables/UserManagement";
import { ref } from "vue";
export default {
  setup() {
    const $q = useQuasar();
    let leftDrawerOpen = ref($q.screen.width > 767 ? true : false);
    return {
      ToggleMenuBtnState,
      ToggleLeftDrawer,
      leftDrawerOpen,
      IsAllowed,
    };
  },
};
</script>

<style lang="scss">
@import "../styles/LeftSideBar.scss";
</style>
