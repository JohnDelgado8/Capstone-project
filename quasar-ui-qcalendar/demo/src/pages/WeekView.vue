<template>
  <div>
    <q-markdown>
::: warning
Codepen uses the UMD version of QCalendar. As such, the examples below must be written in such a way that they also work on that platform. If you see code like `QCalendar.addToDate`, you can instead use `import { addToDate } from '@quasar/quasar-ui-qcalendar'` in your own non-UMD code to get the best tree-shaking effects.
:::
    </q-markdown>
    <example-title title="Week View" />
    <example-viewer title="Basic" file="WeekViewBasic" codepen-title="QCalendar" :location-url="locationUrl" :js-paths="jsPaths" :css-paths="cssPaths" />
    <example-viewer title="Dark" file="WeekViewDark" codepen-title="QCalendar" :location-url="locationUrl" :js-paths="jsPaths" :css-paths="cssPaths" />
    <example-viewer title="First Day Monday" file="WeekViewMondayFirstDay" codepen-title="QCalendar" :location-url="locationUrl" :js-paths="jsPaths" :css-paths="cssPaths" />
    <example-viewer title="5 Day Work Week" file="WeekViewFiveDayWorkWeek" codepen-title="QCalendar" :location-url="locationUrl" :js-paths="jsPaths" :css-paths="cssPaths" />

    <q-markdown>
You can use the `now` property to set a fixed date, otherwise the current date will be used. If the `v-model` property is empty, then it will receive the `now` property's value.

The example below sets the previous day to `now` unless today is Sunday, in which case it sets `now` to the next day.
    </q-markdown>
    <example-viewer title="Now" file="WeekViewNow" codepen-title="QCalendar" :location-url="locationUrl" :js-paths="jsPaths" :css-paths="cssPaths" />

    <example-viewer title="Short Weekday Label" file="WeekViewShortWeekdayLabel" codepen-title="QCalendar" :location-url="locationUrl" :js-paths="jsPaths" :css-paths="cssPaths" />

    <q-markdown>
`hour24-format` is available only for one of the available `day` or `week` views.
    </q-markdown>
    <example-viewer title="Hour24 Format" file="WeekViewHour24Format" codepen-title="QCalendar" :location-url="locationUrl" :js-paths="jsPaths" :css-paths="cssPaths" />

    <q-markdown>
`short-interval-label` is available only for one of the available `day` or `week` views.
    </q-markdown>
    <example-viewer title="Short Interval Label" file="WeekViewShortIntervalLabel" codepen-title="QCalendar" :location-url="locationUrl" :js-paths="jsPaths" :css-paths="cssPaths" />

    <example-viewer title="Short Interval Label (Hour24Format)" file="WeekViewShortIntervalLabelHour24Format" codepen-title="QCalendar" :location-url="locationUrl" :js-paths="jsPaths" :css-paths="cssPaths" />

    <q-markdown>
There may be circumstances where you wish to control the scrolling. In this case, use the `no-scroll` property and provide your own scroll wrapper.

:::
Note: The header area of the calendar will now scroll with the rest of the calendar
:::
    </q-markdown>
    <example-viewer title="No Scroll" file="WeekViewNoScroll" codepen-title="QCalendar" :location-url="locationUrl" :js-paths="jsPaths" :css-paths="cssPaths" />

    <example-title title="Navigation" />
    <example-viewer title="Prev/Next" file="WeekViewPrevNext" codepen-title="QCalendar" :location-url="locationUrl" :js-paths="jsPaths" :css-paths="cssPaths" />
    <example-viewer title="Swipe" file="WeekViewSwipe" codepen-title="QCalendar" :location-url="locationUrl" :js-paths="jsPaths" :css-paths="cssPaths" />

    <example-title title="Disabled" />
    <example-viewer title="Disabled Days" file="WeekViewDisabledDays" codepen-title="QCalendar" :location-url="locationUrl" :js-paths="jsPaths" :css-paths="cssPaths" />

    <q-markdown>
In this example, the `disabled-before` is set to the monday of this week and the `disabled-after` is set to the friday of this week.
    </q-markdown>
    <example-viewer title="Disabled Before/After" file="WeekViewDisabledBeforeAfter" codepen-title="QCalendar" :location-url="locationUrl" :js-paths="jsPaths" :css-paths="cssPaths" />

    <q-markdown>
In this example, the `disabled-weekdays` is set to disable the weekends.
    </q-markdown>
    <example-viewer title="Disabled Weekdays" file="WeekViewDisabledWeekdays" codepen-title="QCalendar" :location-url="locationUrl" :js-paths="jsPaths" :css-paths="cssPaths" />

    <example-title title="Selection" />
    <q-markdown>
In the next example, click on intervals to toggle selected on/off.
    </q-markdown>
    <example-viewer title="Selected Intervals" file="WeekViewSelectedDates" codepen-title="QCalendar" :location-url="locationUrl" :js-paths="jsPaths" :css-paths="cssPaths" />

    <q-markdown>
The example below shows how to use the QCalendar to create a multi-day/multi-interval range selector. The critical aspect of this is the `selected-start-end-dates` property. This takes an array of two dates with time (the first should be less or equal to the last) in format `YYYY-MM-dd hh:mm` (use exported method `getDateTime` to extract from a Timestamp).

For the example below, click an interval, and while holding the mouse down, move to a different interval. Keep in mind, this is just one way of handling multi-day range selection. if you needed swipe navigation on a mobile, you could modify the code to have independent click on start and end days.

Keep in mind that the functionality below won't work with swipe actions.
    </q-markdown>
    <example-viewer title="Multi-Interval Selection (range)" file="WeekViewSelection" codepen-title="QCalendar" :location-url="locationUrl" :js-paths="jsPaths" :css-paths="cssPaths" />

    <example-title title="Header" />
    <q-markdown>
Column Headers are scoped slots only. They are turned on with the `column-header-before` and `column-header-after` properties. Once each property is set to `true` the respective slot is availale.
Column Headers are only available for the `day` (includes 2day, 3day, etc), `week` and `scheduler` views.
The `timestamp` information is passed to the scoped slot.
    </q-markdown>
    <example-viewer title="Column Header" file="WeekViewColumnHeader" codepen-title="QCalendar" :location-url="locationUrl" :js-paths="jsPaths" :css-paths="cssPaths" />

    <example-title title="Events" />
    <q-markdown>
::: tip
The events below won't show up unless there is a listener for it. Therefore, if using `Vue Devtools`, you won't see it unless you add it.
:::

You can add a listener for the following events. An event is comprised of an `event + suffix`. By adding the event with the suffix, you get the completed listener name.

| Event       | `:day:header2`     | `:time2`            | `:interval2`       | `:interval:header2` | `:date2`           |
| ----------- | :----------------: | :----------------: | :----------------: | :-----------------: | :----------------: |
| click       | :heavy_check_mark: | :heavy_check_mark: | :heavy_check_mark: | :heavy_check_mark:  | :heavy_check_mark: |
| contextmenu | :heavy_check_mark: | :heavy_check_mark: | :heavy_check_mark: | :heavy_check_mark:  | :heavy_check_mark: |
| mousedown   | :heavy_check_mark: | :heavy_check_mark: | :heavy_check_mark: | :heavy_check_mark:  | :x:                |
| mousemove   | :heavy_check_mark: | :heavy_check_mark: | :heavy_check_mark: | :heavy_check_mark:  | :x:                |
| mouseup     | :heavy_check_mark: | :heavy_check_mark: | :heavy_check_mark: | :heavy_check_mark:  | :x:                |
| mouseenter  | :heavy_check_mark: | :heavy_check_mark: | :heavy_check_mark: | :heavy_check_mark:  | :x:                |
| mouseleave  | :heavy_check_mark: | :heavy_check_mark: | :heavy_check_mark: | :heavy_check_mark:  | :x:                |
| touchstart  | :heavy_check_mark: | :heavy_check_mark: | :heavy_check_mark: | :heavy_check_mark:  | :x:                |
| touchmove   | :heavy_check_mark: | :heavy_check_mark: | :heavy_check_mark: | :heavy_check_mark:  | :x:                |
| touchend    | :heavy_check_mark: | :heavy_check_mark: | :heavy_check_mark: | :heavy_check_mark:  | :x:                |

::: warning
Do NOT combine suffixes. Only one suffix per event. A different suffix will give you a different event.
:::

| Suffix | Description | Data |
| ------ | ----------- | ---- |
| `:day:header2` | The header area | `{ scope: { timestamp: { "..." }, index: 0 }, event: { "..." } } |
| `:time2` | The slotted area to side of intervals | `{ scope: { timestamp: { "..." }, index: 0 }, event: { "..." } } |
| `:interval2` | The interval area | `{ scope: { timestamp: { "..." } }, event: { "..." } } |
| `:interval:header2` | The header area above the intervals | `{ scope: { days: [ "..." ] }, event: { "..." } } |
| `:date2` | The date button | Date in format YYYY-MM-DD |

::: tip
`:intervals:header2` is new since v2.4.0
:::

::: warning
The events `:day` (now `:day:header2`), `:time`, `:interval` and `:date` have been removed in v3.0.0
:::

The example below is only showing `click` events as well as the `input` event.
    </q-markdown>
    <example-viewer title="Events" file="WeekViewEvents" codepen-title="QCalendar" :location-url="locationUrl" :js-paths="jsPaths" :css-paths="cssPaths" />

    <example-title title="Slots" />
    <q-markdown>
For slots that return `day`, `interval` or `timestamp`, it looks like this:
```js
{
  date: '',       // YYYY-MM-DD
  time: '',       // HH:MM (optional)
  year: 0,        // YYYY
  month: 0,       // MM (Jan = 1, etc)
  day: 0,         // day of the month
  weekday: 0,     // week day
  hour: 0,        // 24-hr
  minute: 0,      // mm
  doy: 0,         // day of year
  workweek: 0,    // workweek number
  hasDay: false,  // if this timestamp is supposed to have a date
  hasTime: false, // if this timestamp is supposed to have a time
  past: false,    // if timestamp is in the past (based on `now` property)
  current: false, // if timestamp is current date (based on `now` property)
  future: false,  // if timestamp is in the future (based on `now` property)
  disabled: false // if timestamp is disabled
}
```

You can use the slots `day-header` and `day-body` to control visual aspects of your event system.
The example below is using the `day-header` slot to indicate there are events on that day, in case it is not visible, indicating to the user they should scroll down to see the event.
The `day-body` slot is used to get information about the date and time of an event and then to calculate where the absolute position of the event based on passed in functions `timeStartPos` and `timeDurationHeight`.
    </q-markdown>
    <example-viewer title="day-header with day-body" file="WeekViewSlots" codepen-title="QCalendar" :location-url="locationUrl" :js-paths="jsPaths" :css-paths="cssPaths" />

    <example-viewer title="head-day" file="WeekViewSlotHeadDay" codepen-title="QCalendar" :location-url="locationUrl" :js-paths="jsPaths" :css-paths="cssPaths" />

    <q-markdown>
You can use the scopedSlot `day-container` to set an absolute position for a time tracking bar.
Scroll down if the current time is later for your location to see the example.
    </q-markdown>
    <example-viewer title="day-container: Show current time" file="WeekViewCurrentTime" codepen-title="QCalendar" :location-url="locationUrl" :js-paths="jsPaths" :css-paths="cssPaths" />

    <example-title title="Customization" />
    <q-markdown>
You can create your own themes by overriding various css vars. You do not have to override all of them (as in the next example), just the ones you need. For building your own themes, head on over to the [Theme Builder](../../quasar-ui-qcalendar/theme-builder)
    </q-markdown>
    <example-viewer title="Colors" file="WeekViewColors" codepen-title="QCalendar" :location-url="locationUrl" :js-paths="jsPaths" :css-paths="cssPaths" />

    <example-title title="Locale Support" />
    <example-viewer title="Locale" file="WeekViewLocale" codepen-title="QCalendar" :location-url="locationUrl" :js-paths="jsPaths" :css-paths="cssPaths" />

  </div>
</template>

<script>
import ExampleTitle from '../components/ExampleTitle'
import { slugify } from 'assets/page-utils'
import { version } from 'ui'

export default {
  name: 'WeekView',

  components: {
    ExampleTitle
  },

  data () {
    return {
      tempToc: [],
      locationUrl: 'https://github.com/quasarframework/quasar-ui-qcalendar/tree/dev/demo/src/examples/',
      jsPaths: [`https://cdn.jsdelivr.net/npm/@quasar/quasar-ui-qcalendar@${version}/dist/index.umd.min.js`],
      cssPaths: [
        `https://cdn.jsdelivr.net/npm/@quasar/quasar-ui-qcalendar@${version}/dist/index.min.css`,
        'https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.12.0/css/all.css'
      ]
    }
  },

  mounted () {
    this.toc = []
    this.tempToc = []
    this.addToToc('Week View')
    this.addToToc('Basic', 2)
    this.addToToc('Dark', 2)
    this.addToToc('First Day Monday', 2)
    this.addToToc('5 Day Work Week', 2)
    this.addToToc('Now', 2)
    this.addToToc('Short Weekday Label', 2)
    this.addToToc('Hour24 Format', 2)
    this.addToToc('Short Interval Label', 2)
    this.addToToc('Short Interval Label (Hour24Format)', 2)
    this.addToToc('No Scroll', 2)

    this.addToToc('Navigation')
    this.addToToc('Prev/Next', 2)
    this.addToToc('Swipe', 2)

    this.addToToc('Disabled')
    this.addToToc('Disabled Days', 2)
    this.addToToc('Disabled Before/After', 2)
    this.addToToc('Disabled Weekdays', 2)

    this.addToToc('Selection')
    this.addToToc('Selected Intervals', 2)
    this.addToToc('Multi-Interval Selection (range)', 2)

    this.addToToc('Header')
    this.addToToc('Column Header', 2)

    this.addToToc('Events')
    this.addToToc('Events', 2)

    this.addToToc('Slots')
    this.addToToc('day-header with day-body', 2)
    this.addToToc('head-day', 2)
    this.addToToc('day-container: Show current time', 2)

    this.addToToc('Customization')
    this.addToToc('Colors', 2)

    this.addToToc('Locale Support')
    this.addToToc('Locale', 2)

    this.toc = this.tempToc
  },

  computed: {
    toc:
    {
      get () {
        return this.$store.state.common.toc
      },
      set (toc) {
        this.$store.commit('common/toc', toc)
      }
    }
  },

  methods: {
    addToToc (name, level = 1) {
      let n = name
      if (level === 1) {
        n = 'title-' + n
      }
      else {
        n = 'example-' + n
      }
      const slug = slugify(n)
      this.tempToc.push({
        children: [],
        id: slug,
        label: name,
        level: level
      })
    }
  }
}
</script>
