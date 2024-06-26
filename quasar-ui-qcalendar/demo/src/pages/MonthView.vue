<template>
  <div>
    <q-markdown>
::: warning
Codepen uses the UMD version of QCalendar. As such, the examples below must be written in such a way that they also work on that platform. If you see code like `QCalendar.addToDate`, you can instead use `import { addToDate } from '@quasar/quasar-ui-qcalendar'` in your own non-UMD code to get the best tree-shaking effects.
:::
    </q-markdown>
    <example-title title="Month View" />
    <example-viewer title="Basic" file="MonthViewBasic" codepen-title="QCalendar" :location-url="locationUrl" :js-paths="jsPaths" :css-paths="cssPaths" />
    <example-viewer title="Dark" file="MonthViewDark" codepen-title="QCalendar" :location-url="locationUrl" :js-paths="jsPaths" :css-paths="cssPaths" />
    <example-viewer title="First Day Monday" file="MonthViewMondayFirstDay" codepen-title="QCalendar" :location-url="locationUrl" :js-paths="jsPaths" :css-paths="cssPaths" />
    <example-viewer title="5 Day Work Week" file="MonthViewFiveDayWorkWeek" codepen-title="QCalendar" :location-url="locationUrl" :js-paths="jsPaths" :css-paths="cssPaths" />
    <example-viewer title="Hide Header" file="MonthViewHideHeader" codepen-title="QCalendar" :location-url="locationUrl" :js-paths="jsPaths" :css-paths="cssPaths" />
    <q-markdown>
The `now` property allows you to set "today's date" to a different date. In the example below, it is set to yesterday's date. This property is only available for `month` view.
    </q-markdown>
    <example-viewer title="Now" file="MonthViewNow" codepen-title="QCalendar" :location-url="locationUrl" :js-paths="jsPaths" :css-paths="cssPaths" />

    <q-markdown>
The `show-work-weeks` property is available only for `month` view. The current Work Week will be highlighted.
    </q-markdown>
    <example-viewer title="Work Weeks" file="MonthViewWorkWeekNumbers" codepen-title="QCalendar" :location-url="locationUrl" :js-paths="jsPaths" :css-paths="cssPaths" />

    <example-viewer title="Short Weekday Label" file="MonthViewShortWeekdayLabel" codepen-title="QCalendar" :location-url="locationUrl" :js-paths="jsPaths" :css-paths="cssPaths" />
    <q-markdown>
You can also use the `:showMonthLabel="false"` to turn the month label off.
    </q-markdown>
    <example-viewer title="Short Month Label" file="MonthViewShortMonthLabel" codepen-title="QCalendar" :location-url="locationUrl" :js-paths="jsPaths" :css-paths="cssPaths" />

    <q-markdown>
The `show-day-of-year-label` property is available only for `month` view.
    </q-markdown>
    <example-viewer title="Show Day of Year Label" file="MonthViewShowDayOfYearLabel" codepen-title="QCalendar" :location-url="locationUrl" :js-paths="jsPaths" :css-paths="cssPaths" />

    <q-markdown>
The `day-height` property is available only for `month` view.

The example below is setting the `day-height` to `100`, the default is `0`, which tells the calendar component to figure out it's own height.
    </q-markdown>
    <example-viewer title="Day Height" file="MonthViewDayHeight" codepen-title="QCalendar" :location-url="locationUrl" :js-paths="jsPaths" :css-paths="cssPaths" />

    <example-title title="Navigation" />
    <example-viewer title="Prev/Next" file="MonthViewPrevNext" codepen-title="QCalendar" :location-url="locationUrl" :js-paths="jsPaths" :css-paths="cssPaths" />
    <example-viewer title="Swipe" file="MonthViewSwipe" codepen-title="QCalendar" :location-url="locationUrl" :js-paths="jsPaths" :css-paths="cssPaths" />

    <example-title title="Outside Days" />
    <q-markdown>
Outside days, in month view, are those days before and after the currently displayed month. By default, these days are disabled to avoid navigation issues when getting selected days from the User. Using the `enable-outside-days` property enables these days.
    </q-markdown>
    <example-viewer title="Enable Outside Days" file="MonthViewEnableOutsideDays" codepen-title="QCalendar" :location-url="locationUrl" :js-paths="jsPaths" :css-paths="cssPaths" />
    <example-viewer title="Hide Outside Days" file="MonthViewHideOutsideDays" codepen-title="QCalendar" :location-url="locationUrl" :js-paths="jsPaths" :css-paths="cssPaths" />

    <example-title title="Disabled" />
    <example-viewer title="Disabled Days" file="MonthViewDisabledDays" codepen-title="QCalendar" :location-url="locationUrl" :js-paths="jsPaths" :css-paths="cssPaths" />

    <q-markdown>
In this next example, the `disabled-before` is set to the last day of the previous month and the `disabled-after` is set to the first day of the next month. Essentially, this disables all dates but the current month.
    </q-markdown>
    <example-viewer title="Disabled Before/After" file="MonthViewDisabledBeforeAfter" codepen-title="QCalendar" :location-url="locationUrl" :js-paths="jsPaths" :css-paths="cssPaths" />

    <q-markdown>
In this next example, the `disabled-weekdays` is set to disable the weekends.
    </q-markdown>
    <example-viewer title="Disabled Weekdays" file="MonthViewDisabledWeekdays" codepen-title="QCalendar" :location-url="locationUrl" :js-paths="jsPaths" :css-paths="cssPaths" />

    <example-title title="Selection" />
    <q-markdown>
In the next example, click on dates to toggle selected on/off. Care is taken to exclude `outside` dates (dates that fall outside the current month).
    </q-markdown>
    <example-viewer title="Selected Dates" file="MonthViewSelectedDates" codepen-title="QCalendar" :location-url="locationUrl" :js-paths="jsPaths" :css-paths="cssPaths" />

    <q-markdown>
The example below shows how to use the QCalendar to create a multi-day range selector. The critical aspect of this is the `selected-start-end-dates` property. This takes an array of two dates (the first should be less or equal to the last).

For the example below, click a day, and while holding the mouse down, move to a different day. Keep in mind, this is just one way of handling multi-day range selection. if you needed swipe navigation on a mobile, you could modify the code to have independent click on start and end days.

Keep in mind that the functionality below won't work with swipe actions.
    </q-markdown>
    <example-viewer title="Multi-Day Selection (range)" file="MonthViewSelection" codepen-title="QCalendar" :location-url="locationUrl" :js-paths="jsPaths" :css-paths="cssPaths" />

    <example-title title="Events" />
    <q-markdown>
::: tip
The events below won't show up unless there is a listener for it. Therefore, if using `Vue Devtools`, you won't see it unless you add it.
:::

You can add a listener for the following events. An event is comprised of an `event + suffix`. By adding the event with the suffix, you get the completed listener name.

| Event       | `:day2`            | `:workweek2`        | `:workweek:header2` | `:day:header2`     | `:date2`           |
| ----------- | :----------------: | :----------------: | :-----------------: | :----------------: | :----------------: |
| click       | :heavy_check_mark: | :heavy_check_mark: | :heavy_check_mark:  | :heavy_check_mark: | :heavy_check_mark: |
| contextmenu | :heavy_check_mark: | :heavy_check_mark: | :heavy_check_mark:  | :heavy_check_mark: | :heavy_check_mark: |
| mousedown   | :heavy_check_mark: | :heavy_check_mark: | :heavy_check_mark:  | :heavy_check_mark: | :x:                |
| mousemove   | :heavy_check_mark: | :heavy_check_mark: | :heavy_check_mark:  | :heavy_check_mark: | :x:                |
| mouseup     | :heavy_check_mark: | :heavy_check_mark: | :heavy_check_mark:  | :heavy_check_mark: | :x:                |
| mouseenter  | :heavy_check_mark: | :heavy_check_mark: | :heavy_check_mark:  | :heavy_check_mark: | :x:                |
| mouseleave  | :heavy_check_mark: | :heavy_check_mark: | :heavy_check_mark:  | :heavy_check_mark: | :x:                |
| touchstart  | :heavy_check_mark: | :heavy_check_mark: | :heavy_check_mark:  | :heavy_check_mark: | :x:                |
| touchmove   | :heavy_check_mark: | :heavy_check_mark: | :heavy_check_mark:  | :heavy_check_mark: | :x:                |
| touchend    | :heavy_check_mark: | :heavy_check_mark: | :heavy_check_mark:  | :heavy_check_mark: | :x:                |

::: warning
Do NOT combine suffixes. Only one suffix per event. A different suffix will give you a different event.
:::

| Suffix | Description | Data |
| ------ | ----------- | ---- |
| `:day2` | The day area | `{ scope: { timestamp: { "..." }, outside, miniMode }, event: { "..." } } |
| `:workweek2` | A workweek area | `{ scope: { workweekLabel, week: [ "..." ], miniMode }, event: { "..." } } |
| `:workweek:header2` | The area above the workweeks | `{ scope: { start: { "..." }, end: { "..." }, miniMode }, event: { "..." } } |
| `:day:header2` | The header area that includes weekday | `{ scope: { timestamp: { "..." }, days: [ "..." ], index, miniMode }, event: { "..." } } |
| `:date2` | The date button | Date in format YYYY-MM-DD |

::: tip
`:workweek:header2` and  `:day:header2` are new since v2.4.0
:::

::: warning
The events `:day` (now `:day:header2`), `:time`, `:interval` and `:date` have been removed in v3.0.0
:::

The example below is only showing `click` events as well as the `input` event.
    </q-markdown>
    <example-viewer title="Events" file="MonthViewEvents" codepen-title="QCalendar" :location-url="locationUrl" :js-paths="jsPaths" :css-paths="cssPaths" />

    <example-title title="Slots" />
    <q-markdown>
The `#day` slot allows you to write anything into the content body of the day.

For slots that return `timestamp`, it looks like this:
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
The example below uses the `#day` slot. This constrains your slotted output to that specific day. For a less-constrained slot, look into the `#week` slot further below.

    </q-markdown>
    <example-viewer title="Slot (day)" file="MonthViewSlots" codepen-title="QCalendar" :location-url="locationUrl" :js-paths="jsPaths" :css-paths="cssPaths" />

    <q-markdown>
The example below uses the **#week** slot (v1.3.2). It's a bit more difficult to work with than the **#day** slot, but allows you to have your devland events displayed in a contiguous manner. Check out the sources to see how it is accomplished.

::: warning
Do not mix `#day` and `#week` slots or you will have overlapping results.
:::

::: tip
If you set the property `day-height` to 0, then the height will automatically be adjusted to account for events that might otherwise become hidden.
:::

    </q-markdown>
    <example-viewer title="Slot (week)" file="MonthViewWeekSlot" codepen-title="QCalendar" :location-url="locationUrl" :js-paths="jsPaths" :css-paths="cssPaths" />
    <example-viewer title="Slot (head-day)" file="MonthViewSlotHeadDay" codepen-title="QCalendar" :location-url="locationUrl" :js-paths="jsPaths" :css-paths="cssPaths" />

    <example-title title="Customization" />
    <q-markdown>
You can create your own themes by overriding various css vars. You do not have to override all of them (as in the next example), just the ones you need. For building your own themes, head on over to the [Theme Builder](../../quasar-ui-qcalendar/theme-builder)
    </q-markdown>
    <example-viewer title="Colors" file="MonthViewColors" codepen-title="QCalendar" :location-url="locationUrl" :js-paths="jsPaths" :css-paths="cssPaths" />

    <example-title title="Locale Support" />
    <example-viewer title="Locale" file="MonthViewLocale" codepen-title="QCalendar" :location-url="locationUrl" :js-paths="jsPaths" :css-paths="cssPaths" />

    <example-title title="Customizations" />
    <q-markdown>
QCalendar does not come with a navigation toolbar out-of-the-box because we believe developers/designers should be able to make their own custom controls that are visually appealing to their audience. This keeps QCalendar less opinionated of how you want your calendar to look.

This example is only one of many ways you can style your own QCalendar.
    </q-markdown>
    <example-viewer title="Toolbar" file="MonthViewToolbar" codepen-title="QCalendar" :location-url="locationUrl" :js-paths="jsPaths" :css-paths="cssPaths" />

    <q-markdown>
This next example shows how you can customize QCalendar with some css. This example targets both the `current` and `active` dates (so don't forget to click on a date).
    </q-markdown>
    <example-viewer title="CSS" file="MonthViewCustomCurrentDay" codepen-title="QCalendar" :location-url="locationUrl" :js-paths="jsPaths" :css-paths="cssPaths" />

  </div>
</template>

<script>
import ExampleTitle from '../components/ExampleTitle'
import { slugify } from 'assets/page-utils'
import { version } from 'ui'

export default {
  name: 'MonthView',

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
    this.addToToc('Month View')
    this.addToToc('Basic', 2)
    this.addToToc('Dark', 2)
    this.addToToc('First Day Monday', 2)
    this.addToToc('5 Day Work Week', 2)
    this.addToToc('Hide Header', 2)
    this.addToToc('Now', 2)
    this.addToToc('Work Weeks', 2)
    this.addToToc('Short Weekday Label', 2)
    this.addToToc('Short Month Label', 2)
    this.addToToc('Show Day of Year Label', 2)
    this.addToToc('Day Height', 2)

    this.addToToc('Navigation')
    this.addToToc('Prev/Next', 2)
    this.addToToc('Swipe', 2)

    this.addToToc('Outside Days')
    this.addToToc('Enable Outside Days', 2)
    this.addToToc('Hide Outside Days', 2)

    this.addToToc('Disabled')
    this.addToToc('Disabled Days', 2)
    this.addToToc('Disabled Before/After', 2)
    this.addToToc('Disabled Weekdays', 2)

    this.addToToc('Selection')
    this.addToToc('Selected Dates', 2)
    this.addToToc('Multi-Day Selection (range)', 2)

    this.addToToc('Events')
    this.addToToc('Events', 2)

    this.addToToc('Slots')
    this.addToToc('Slot (day)', 2)
    this.addToToc('Slot (week)', 2)
    this.addToToc('Slot (head-day)', 2)

    this.addToToc('Customization')
    this.addToToc('Colors', 2)

    this.addToToc('Locale Support')
    this.addToToc('Locale', 2)

    this.addToToc('Customizations')
    this.addToToc('Toolbar', 2)
    this.addToToc('CSS', 2)

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
