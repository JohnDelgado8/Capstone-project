<template>
  <q-list class="menu">
    <q-item clickable to="/docs">
      <q-item-section avatar>
        <q-icon name="calendar_today" />
      </q-item-section>
      <q-item-section>
        <q-item-label>QCalendar docs</q-item-label>
        <q-item-label caption>Documentation</q-item-label>
      </q-item-section>
    </q-item>
    <q-item clickable to="/demo">
      <q-item-section avatar>
        <q-icon name="calendar_today" />
      </q-item-section>
      <q-item-section>
        <q-item-label>QCalendar demo</q-item-label>
        <q-item-label caption>Interactively play with properties</q-item-label>
      </q-item-section>
    </q-item>

    <q-item clickable to="/examples">
      <q-item-section avatar>
        <q-icon name="calendar_today" />
      </q-item-section>
      <q-item-section>
        <q-item-label>QCalendar examples</q-item-label>
        <q-item-label caption>Examples of how to do it</q-item-label>
      </q-item-section>
    </q-item>

    <q-item clickable to="/theme-builder">
      <q-item-section avatar>
        <q-icon name="fas fa-palette" />
      </q-item-section>
      <q-item-section>
        <q-item-label>Theme Builder</q-item-label>
        <q-item-label caption>Build QCalendar themes</q-item-label>
      </q-item-section>
    </q-item>

    <q-separator />

    <q-item clickable tag="a" target="_blank" href="https://github.com/quasarframework/quasar-ui-qcalendar">
      <q-item-section avatar>
        <q-icon name="home" />
      </q-item-section>
      <q-item-section>
        <q-item-label>QCalendar home</q-item-label>
        <q-item-label caption>@quasar/qcalendar</q-item-label>
      </q-item-section>
    </q-item>
    <q-item clickable tag="a" target="_blank" href="https://github.com/quasarframework/quasar-ui-qmarkdown">
      <q-item-section avatar>
        <q-icon name="fab fa-markdown" />
      </q-item-section>
      <q-item-section>
        <q-item-label>QMarkdown home</q-item-label>
        <q-item-label caption>@quasar/qmarkdown</q-item-label>
      </q-item-section>
    </q-item>
    <q-item clickable tag="a" target="_blank" href="https://twitter.com/jgalbraith64">
      <q-item-section avatar>
        <q-icon name="fab fa-twitter"></q-icon>
      </q-item-section>
      <q-item-section>
        <q-item-label>Jeff's Twitter</q-item-label>
        <q-item-label caption>@jgalbraith64</q-item-label>
      </q-item-section>
    </q-item>
    <q-separator />
    <q-item-label header>Quasar</q-item-label>
    <q-separator />
    <q-item clickable tag="a" target="_blank" href="http://quasar.dev">
      <q-item-section avatar>
        <q-icon name="school" />
      </q-item-section>
      <q-item-section>
        <q-item-label>Docs</q-item-label>
        <q-item-label caption>quasar.dev</q-item-label>
      </q-item-section>
    </q-item>
    <q-item clickable tag="a" target="_blank" href="https://github.com/quasarframework/">
      <q-item-section avatar>
        <q-icon name="code" />
      </q-item-section>
      <q-item-section>
        <q-item-label>Github</q-item-label>
        <q-item-label caption>github.com/quasarframework</q-item-label>
      </q-item-section>
    </q-item>
    <q-item clickable tag="a" target="_blank" href="http://chat.quasar.dev">
      <q-item-section avatar>
        <q-icon name="chat" />
      </q-item-section>
      <q-item-section>
        <q-item-label>Discord Chat Channel</q-item-label>
        <q-item-label caption>chat.quasar.dev</q-item-label>
      </q-item-section>
    </q-item>
    <q-item clickable tag="a" target="_blank" href="https://forum.quasar.dev">
      <q-item-section avatar>
        <q-icon name="record_voice_over" />
      </q-item-section>
      <q-item-section>
        <q-item-label>Forum</q-item-label>
        <q-item-label caption>forum.quasar.dev</q-item-label>
      </q-item-section>
    </q-item>
    <q-item clickable tag="a" target="_blank" href="https://twitter.com/quasarframework">
      <q-item-section avatar>
        <q-icon name="rss_feed" />
      </q-item-section>
      <q-item-section>
        <q-item-label>Twitter</q-item-label>
        <q-item-label caption>@quasarframework</q-item-label>
      </q-item-section>
    </q-item>
  </q-list>
</template>

<script>
export default {
  name: 'EssentialLinks',
  data () {
    return {}
  }
}
</script>
