<template>
  <q-layout view="HHh LpR fFf" @scroll="onScroll">
    <q-header elevated>
      <q-toolbar>
        <q-btn
          flat
          dense
          round
          icon="menu"
          @click="leftDrawerOpen = !leftDrawerOpen"
          aria-label="Menu"
        />

        <q-toolbar-title>
          QCalendar <span class="text-subtitle2">v{{ version }}</span>
        </q-toolbar-title>

        <q-space />

        <q-btn flat round @click="$q.dark.toggle()" :icon="$q.dark.isActive ? 'brightness_2' : 'brightness_5'" />
        <div v-if="$q.screen.width > 500">Quasar v{{ $q.version }}</div>

        <q-btn
          flat
          dense
          round
          @click="rightDrawerOpen = !rightDrawerOpen"
          aria-label="Table of Contents"
        >
          <q-icon name="menu" />
        </q-btn>

      </q-toolbar>
    </q-header>

    <q-drawer
      v-model="leftDrawerOpen"
      show-if-above
      bordered
      aria-label="Menu"
      class="menu"
    >
      <div class="col-12">
        <q-expansion-item
          expand-separator
          default-opened
          group="somegroup"
          icon="fas fa-cogs"
          label="QCalendar"
          caption="QCalendar Examples"
          class="menu"
        >
          <q-separator />
          <q-list dense>

            <q-item
              to="/examples/day-view"
              clickable
            >
              <q-item-section avatar>
                <q-icon name="fas fa-calendar-day" />
              </q-item-section>
              <q-item-section>
                <q-item-label>Day View</q-item-label>
              </q-item-section>
            </q-item>

            <q-item
              to="/examples/week-view"
              clickable
            >
              <q-item-section avatar>
                <q-icon name="fas fa-calendar-week" />
              </q-item-section>
              <q-item-section>
                <q-item-label>Week View</q-item-label>
              </q-item-section>
            </q-item>

            <q-item
              to="/examples/month-view"
              clickable
            >
              <q-item-section avatar>
                <q-icon name="fas fa-calendar-alt" />
              </q-item-section>
              <q-item-section>
                <q-item-label>Month View</q-item-label>
              </q-item-section>
            </q-item>

            <q-item
              to="/examples/month-view-mini-mode"
              clickable
            >
              <q-item-section avatar>
                <q-icon name="far fa-calendar" />
              </q-item-section>
              <q-item-section>
                <q-item-label>Month View (mini-mode)</q-item-label>
              </q-item-section>
            </q-item>

            <q-item
              to="/examples/scheduler-view"
              clickable
            >
              <q-item-section avatar>
                <q-icon name="fas fa-calendar" />
              </q-item-section>
              <q-item-section>
                <q-item-label>Scheduler View</q-item-label>
              </q-item-section>
            </q-item>

            <q-item
              to="/examples/resource-view"
              clickable
            >
              <q-item-section avatar>
                <q-icon name="fas fa-grip-horizontal" />
              </q-item-section>
              <q-item-section>
                <q-item-label>Resource View</q-item-label>
              </q-item-section>
            </q-item>

            <q-item
              to="/examples/agenda-view"
              clickable
            >
              <q-item-section avatar>
                <q-icon name="view_agenda" />
              </q-item-section>
              <q-item-section>
                <q-item-label>Agenda View</q-item-label>
              </q-item-section>
            </q-item>

            <q-item
              to="/demos/planner"
              clickable
            >
              <q-item-section avatar>
                <q-icon name="fas fa-th" />
              </q-item-section>
              <q-item-section>
                <q-item-label>Planner</q-item-label>
              </q-item-section>
            </q-item>

          </q-list>
        </q-expansion-item>

        <q-expansion-item
          expand-separator
          group="somegroup"
          icon="fas fa-link"
          label="Essential Links"
        >
          <q-separator />
          <essential-links />
        </q-expansion-item>
        <q-separator />
      </div>
    </q-drawer>

    <q-drawer
      ref="drawer"
      v-model="rightDrawerOpen"
      show-if-above
      side="right"
      bordered
      aria-label="Table of Contents"
      class="toc"
    >
      <q-scroll-area class="fit">
        <q-list dense>
          <q-item
            v-for="item in toc"
            :key="item.id"
            clickable
            v-ripple
            dense
            @click="scrollTo(item.id)"
            :active="activeToc === item.id"
          >
          <q-item-section v-if="item.level > 1" side> • </q-item-section>
            <q-item-section
              :class="`toc-item toc-level-${item.level}`"
            >{{ item.label }}</q-item-section>
          </q-item>
        </q-list>
      </q-scroll-area>
    </q-drawer>

    <q-page-container>
      <transition name="fade">
        <router-view />
      </transition>
    </q-page-container>
    <q-page-scroller position="bottom-right" :scroll-offset="150" :offset="[18, 18]">
      <q-btn
        fab
        icon="keyboard_arrow_up"
        :class="{ 'text-black bg-grey-4': $q.dark.isActive, 'text-white bg-primary': !$q.dark.isActive }"
      />
    </q-page-scroller>

  </q-layout>
</template>

<script>
import { mapGetters } from 'vuex'
import { scroll } from 'quasar'
const { setScrollPosition } = scroll
import { version } from 'ui'

export default {
  name: 'ExamplesLayout',
  components: {
    'essential-links': () => import('../components/EssentialLinks')
  },
  data () {
    return {
      version: version,
      leftDrawerOpen: this.$q.platform.is.desktop,
      rightDrawerOpen: this.$q.platform.is.desktop,
      activeToc: 0
    }
  },
  mounted () {
    // code to handle anchor link on refresh/new page, etc
    if (location.hash !== '') {
      const id = location.hash.slice(1)
      setTimeout(() => {
        this.scrollTo(id)
      }, 200)
    }
  },
  computed: {
    ...mapGetters({
      toc: 'common/toc'
    })
  },
  methods: {
    scrollTo (id) {
      this.activeToc = id
      const el = document.getElementById(id)

      if (el) {
        setTimeout(() => {
          this.scrollPage(el)
        }, 200)
      }
    },
    scrollPage (el) {
      // const target = getScrollTarget(el)
      const offset = el.offsetTop - 50
      // setScrollPosition(target, offset, 500)
      setScrollPosition(window, offset, 500)
    },
    onScroll ({ position }) {
      if (this.scrollingPage !== true) {
        this.updateActiveToc(position)
      }
    },
    updateActiveToc (position) {
      const toc = this.toc
      let last

      for (const i in toc) {
        const section = toc[i]
        const item = document.getElementById(section.id)

        if (item === null) {
          continue
        }

        if (item.offsetTop >= position + 50) {
          if (last === undefined) {
            last = section.id
          }
          break
        }
      }

      if (last !== undefined) {
        this.activeToc = last
      }
    }
  }
}
</script>
