<template>
  <q-page padding>
    <div v-if="$q.platform.is.mobile">
      If on mobile, try rotating your screen to landscape mode for best viewing of the Planner<br><br>
    </div>

    <q-markdown>
This page is a **WIP** - please consider making a **PR** to make this better, it will be appreciated :heart:. You can view the source for [Planner](https://github.com/quasarframework/quasar-ui-qcalendar/blob/dev/demo/src/pages/Planner.vue) and [PlannerItem](https://github.com/quasarframework/quasar-ui-qcalendar/blob/dev/demo/src/components/PlannerItem.vue) on Github.

Drag-and-Drop has been implemented. Give it a try. :)

---
    </q-markdown>
    <q-btn flat dense label="Today" class="q-mx-md" @click="setToday"></q-btn>
    <q-btn flat dense round icon="keyboard_arrow_left" @click="onPrev"></q-btn>
    <q-btn flat dense round icon="keyboard_arrow_right" @click="onNext"></q-btn>
    <span class="q-mr-xl q-toolbar__title nowrap">{{ title }}</span>

    <q-calendar
      ref="calendar"
      v-model="selectedDate"
      :view="$q.screen.lt.md ? '3day-agenda' : 'week-agenda'"
      :weekdays="[1,2,3,4,5]"
      :left-column-options="leftColumnOptions"
      :right-column-options="rightColumnOptions"
      bordered
      @change="onChange"
      style="height: calc(100vh - 300px); min-height: 400px;"
    >
      <template #column-header-label="{ id, label }">
        <template v-if="id === 'over-due'">
          <div class="row items-center no-wrap">
            <q-icon
              :name="overdueSelected ? 'check_box' : 'check_box_outline_blank'"
              :class="'cursor-pointer' + (overdueSelected ? ' text-red-8' : ' text-blue-8')"
              @click="overdueSelected = !overdueSelected"
              style="font-size: 24px;"
              v-ripple
            />
            <span class="ellipsis">{{ label }}</span>
          </div>
        </template>
        <template v-else>
          <div class="row items-center no-wrap">
            <span class="ellipsis">{{ label }}</span>
          </div>
        </template>
      </template>

      <template #day-header-label="{ timestamp }">
        <div class="row items-center no-wrap">
          <q-icon
            :name="selected[timestamp.weekday - 1] === true ? 'check_box' : 'check_box_outline_blank'"
            :class="'cursor-pointer' + (selected[timestamp.weekday - 1] ? ' text-red-8' : ' text-blue-8')"
            @click.stop.prevent="$set(selected, timestamp.weekday - 1, !selected[timestamp.weekday - 1])"
            style="font-size: 24px;"
            v-ripple
          />
          <span class="ellipsis">{{ weekdayFormatter(timestamp, $q.screen.lt.lg) }}</span>
        </div>
      </template>

      <template #column-body="{ column }">
        <template v-if="column.id === 'over-due'">
          <q-card class="q-mr-xs q-mb-xs q-px-sm row justify-between">
            <div class="cursor-pointer"><q-icon name="add"/>Add Job</div>
            <div class="cursor-pointer"><q-icon name="note_add" />Add Note</div>
          </q-card>
          <div
            class="planner-column"
            data-column="overdue"
            @dragover.stop="onDragOver"
            @drop.stop="onDrop"
          >
            <transition-group name="planner-item">
              <template v-for="item in overdue">
                <planner-item
                  :data-id="item.id"
                  :key="item.id"
                  v-model="item.selected"
                  :name="item.name"
                  :address="item.address"
                  :email="item.email"
                  :phone="item.phone"
                  :work-done="item.workDone"
                  :work-date="item.workDate"
                  :amount="item.amount"
                  :days-over="item.daysOver"
                  :draggable="true"
                  @dragstart.stop.native="(e) => onDragStart(e, item)"
                  @dragend.stop.native="onDragEnd"
                  @dragenter.stop.native="onDragEnter"
                  @dragleave.stop.native="onDragLeave"
                  @dragover.stop.native="onDragOver"
                  @drop.stop.native="onDrop"
                  @touchmove.stop.native="(e) => onTouchMove(e, item)"
                  @touchstart.stop.native="(e) => onTouchStart(e, item)"
                  @touchend.stop.native="onTouchEnd"
                />
              </template>
            </transition-group>
          </div>
        </template>
      </template>

      <template #day-body="{ timestamp }">
        <q-card class="q-mr-xs q-mb-xs q-px-sm row justify-between">
          <div class="cursor-pointer"><q-icon name="add" />Add Job</div>
          <div class="cursor-pointer"><q-icon name="note_add" />Add Note</div>
        </q-card>
        <div
          class="planner-column"
          :data-column="timestamp.weekday"
          @dragover.stop="onDragOver"
          @drop.stop="onDrop"
        >
          <transition-group name="planner-item">
            <template v-for="item in getAgenda(timestamp)">
              <planner-item
                :data-id="item.id"
                :key="item.id"
                v-model="item.selected"
                :name="item.name"
                :address="item.address"
                :email="item.email"
                :phone="item.phone"
                :work-done="item.workDone"
                :work-date="item.workDate"
                :amount="item.amount"
                :days-over="item.daysOver"
                :draggable="true"
                @dragstart.stop.native="(e) => onDragStart(e, item)"
                @dragend.stop.native="onDragEnd"
                @dragenter.stop.native="onDragEnter"
                @dragleave.stop.native="onDragLeave"
                @dragover.stop.native="onDragOver"
                @drop.stop.native="onDrop"
                @touchmove.stop.native="(e) => onTouchMove(e, item)"
                @touchstart.stop.native="(e) => onTouchStart(e, item)"
                @touchend.stop.native="onTouchEnd"
              />
            </template>
          </transition-group>
        </div>
      </template>

    </q-calendar>
  </q-page>
</template>

<script>
// import 'drag-drop-touch'
let itemId = 1

import { getLocale } from '../util/getLocale'
import { padTime } from '../util/time'

// normally you would not import "all" of QCalendar, but is needed for this example to work with UMD (codepen)
import QCalendar from 'ui' // ui is aliased from '@quasar/quasar-ui-qcalendar'

const names = ['Ezekiel Stout', 'Aurora Frank', 'Ethan Buchanan', 'Sam Parker', 'Jonathan Hall', 'Carl Flynn', 'Raymond Ingram', 'Abel Glover', 'Margaret Medina', 'Jalen Kane', 'Monserrat Stein', 'Andres Gentry']
const addresses = ['262 East Cypress Drive', '8719 Anderson Road', '242 W. Shady Road', '4 Lexington Avenue', '7940 Sunset Court', '9866 NE. Rockaway Ave.', '9 Santa Clara Drive', '774 Charles Road', '5 East Thomas St.', '7714 Lilac Rd.', '561 Bowman St.', '517 Brickell Ave.']
const emails = ['qmacro@me.com', 'amimojo@gmail.com', 'padme@mac.com', 'flaviog@verizon.net', 'srour@mac.com', 'retoh@outlook.com', 'pappp@me.com', 'mcraigw@hotmail.com', 'smcnabb@hotmail.com', 'rnelson@att.net', 'fwitness@live.com', 'stomv@aol.com']
const phones = ['555-555-0000', '555-555-1111', '555-555-2222', '555-555-3333', '555-555-4444', '555-555-5555', '555-555-6666', '555-555-7777', '555-555-8888', '555-555-9999']
const workDone = ['Window cleaning', 'Exterior cleaning', 'Lawn maintenance', 'Tree service', 'Flower bed maintenance']

export default {
  name: 'Planner',

  components: {
    PlannerItem: () => import('../components/PlannerItem')
  },

  data () {
    return {
      selectedDate: '',
      today: '',
      todayTimestamp: '',
      startTimestamp: '',
      endTimestamp: '',
      weekdays: [1, 2, 3, 4, 5],
      leftColumnOptions: [
        {
          id: 'over-due',
          label: 'Over Due'
        }
      ],
      // rightColumnOptions: [
      //   {
      //     id: 'summary',
      //     label: 'Summary'
      //   }
      // ],
      rightColumnOptions: undefined,
      local: 'en-us',
      dateFormatter: undefined,
      titleFormatter: undefined,
      overdueSelected: false,
      selected: [
        false,
        false,
        false,
        false,
        false
      ],
      overdue: [],
      agenda: {
        // value represents day of the week
        1: [],
        2: [],
        3: [],
        4: [],
        5: []
      }
    }
  },

  mounted () {
    this.locale = getLocale()
    this.updateFormatters()
    this.today = this.formatDate() // save today's date
    this.todayTimestamp = QCalendar.parseTimestamp(this.today)
    this.setToday() // set calendar to today's date
    // this.generateLists()
    // we do this here because we don't want it Vue reactive
    this.dragEl = null
    this.curColEl = null
    this.curChildEl = null
    this.currentColumn = null
    this.currentItemId = null
    this.currentItem = null
    this.targetColumn = null
    this.targetItemId = null
    this.copyElement = null
    this.pageX = 0
    this.pageY = 0
  },

  beforeDestroy () {
    // just to make sure there are no memory leaks
    this.cleanup()
  },

  computed: {
    title () {
      if (this.titleFormatter && this.locale && this.selectedDate) {
        const date = new Date(this.selectedDate)
        return this.titleFormatter.format(date)
      }
      return ''
    },

    weekdayFormatter () {
      const longOptions = { timeZone: 'UTC', weekday: 'long' }
      const shortOptions = { timeZone: 'UTC', weekday: 'short' }

      return QCalendar.createNativeLocaleFormatter(
        this.locale,
        (_tms, short) => short ? shortOptions : longOptions
      )
    }
  },

  watch: {
    overdueSelected (val) {
      this.overdue.forEach(due => {
        due.selected = val
      })
    },

    'selected.0' (val, oldVal) {
      this.agenda[1].forEach(ag => {
        ag.selected = val
      })
    },

    'selected.1' (val, oldVal) {
      this.agenda[2].forEach(ag => {
        ag.selected = val
      })
    },

    'selected.2' (val, oldVal) {
      this.agenda[3].forEach(ag => {
        ag.selected = val
      })
    },

    'selected.3' (val, oldVal) {
      this.agenda[4].forEach(ag => {
        ag.selected = val
      })
    },

    'selected.4' (val, oldVal) {
      this.agenda[5].forEach(ag => {
        ag.selected = val
      })
    }
  },

  methods: {
    getAgenda (day) {
      return this.agenda[parseInt(day.weekday, 10)]
    },

    setToday () {
      this.selectedDate = this.formatDate()
      this.generateLists()
    },

    onPrev () {
      this.$refs.calendar.prev()
      this.generateLists()
    },

    onNext () {
      this.$refs.calendar.next()
      this.generateLists()
    },

    formatDate (date) {
      const d = date !== undefined ? new Date(date) : new Date(),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear()

      return [year, padTime(month), padTime(day)].join('-')
    },

    updateFormatters () {
      try {
        this.dateFormatter = new Intl.DateTimeFormat(this.locale || undefined, {
          year: 'numeric',
          month: '2-digit',
          day: '2-digit',
          hour: '2-digit',
          minute: '2-digit',
          second: '2-digit',
          hour12: false,
          timeZone: 'UTC'
        })

        this.titleFormatter = new Intl.DateTimeFormat(this.locale || undefined, {
          month: this.shortMonthLabel ? 'short' : 'long',
          year: 'numeric',
          timeZone: 'UTC'
        })
      }
      catch (e) {
        // console.error('Intl.DateTimeFormat not supported')
        this.dateFormatter = undefined
        this.titleFormatter = undefined
      }
    },

    // this is called whenever the calendar start/end dates change
    onChange ({ start, end }) {
      this.startTimestamp = start
      this.endTimestamp = end
    },

    generateLists () {
      this.generateList(this.overdue, Math.floor(Math.random() * 10) + 3, this.startTimestamp, true)
      this.generateList(this.agenda[1], Math.floor(Math.random() * 10) + 3, this.startTimestamp)
      this.generateList(this.agenda[2], Math.floor(Math.random() * 10) + 3, this.startTimestamp)
      this.generateList(this.agenda[3], Math.floor(Math.random() * 10) + 3, this.startTimestamp)
      this.generateList(this.agenda[4], Math.floor(Math.random() * 10) + 3, this.startTimestamp)
      this.generateList(this.agenda[5], Math.floor(Math.random() * 10) + 3, this.startTimestamp)
      this.adjustSelected()
    },

    generateList (list, count, timestamp, overdue = false) {
      const items = []
      for (let i = 0; i < count; ++i) {
        items[i] = {}
        items[i].selected = false
        items[i].id = itemId++
        items[i].address = addresses[Math.floor((Math.random() * 100) % addresses.length)]
        items[i].name = names[Math.floor((Math.random() * 100) % names.length)]
        items[i].email = emails[Math.floor((Math.random() * 100) % emails.length)]
        items[i].phone = phones[Math.floor((Math.random() * 100) % phones.length)]
        items[i].amount = this.generateAmount()
        items[i].workDate = overdue === true ? this.generateDate(timestamp) : timestamp.date
        items[i].workDone = workDone[Math.floor((Math.random() * 100) % workDone.length)]
        items[i].daysOver = overdue === true ? this.getDaysBetween(items[i].workDate, this.today) : 0
      }
      list.splice(0, list.length, ...items)
    },

    generateDate (startTimestamp) {
      const days = Math.floor((Math.random() * 100) % 30) + 1
      let ts = QCalendar.moveRelativeDays(startTimestamp, QCalendar.prevDay, days)
      ts = QCalendar.updateFormatted(ts) // needed to update static values after date change
      return ts.date
    },

    getDaysBetween (startDate, endDate) {
      const timestampStart = QCalendar.parseTimestamp(startDate)
      const timestampEnd = QCalendar.parseTimestamp(endDate)
      return QCalendar.daysBetween(timestampStart, timestampEnd)
    },

    generateAmount () {
      const integer = QCalendar.padNumber(Math.floor(Math.random() * 100), 2)
      const fractional = QCalendar.padNumber(Math.floor(Math.random() * 100), 2)
      return integer + '.' + fractional
    },

    adjustSelected () {
      this.overdue.forEach(due => {
        due.selected = this.overdueSelected
      })

      this.selected.forEach((sel, index) => {
        this.agenda[index + 1].forEach(ag => {
          ag.selected = sel
        })
      })
    },

    onDragStart (e, item) {
      if (e.dataTransfer) {
        e.dataTransfer.setData('text/html', e.currentTarget.innerHTML)
      }
      const child = this.getCorrectTarget(e.currentTarget, 'planner-item')
      child.style.opacity = '0'
      this.dragEl = child
      this.currentColumn = this.getColumnFromTarget(child)
      this.getCurrentItemId = this.getItemIdFromTarget(child)
      this.currentItem = item
    },

    onDragEnd (e) {
      e.currentTarget.style.opacity = '1.0'

      if (this.curChildEl) {
        this.curChildEl.classList.remove('drag-over-item')
      }

      if (this.curColEl) {
        this.curColEl.classList.remove('drag-over')
      }
    },

    onDragEnter (e, column, child) {
      if (!column && !child) {
        column = this.getCorrectTarget(e.currentTarget, 'planner-column')
        child = this.getCorrectTarget(e.currentTarget, 'planner-item')
      }

      // check column
      if (this.curColEl !== column) {
        if (this.curColEl) {
          this.curColEl.classList.remove('drag-over')
        }
        this.curColEl = column
        if (this.curColEl) {
          this.curColEl.classList.add('drag-over')
        }
      }

      // check item
      if (this.curChildEl !== child) {
        if (this.curChildEl) {
          this.curChildEl.classList.remove('drag-over-item')
        }
        this.curChildEl = child
        if (this.curChildEl && this.dragEl !== child) {
          this.curChildEl.classList.add('drag-over-item')
        }
      }
    },

    onDragLeave (e) {
      // nothing to do
    },

    onDragOver (e) {
      if (e.preventDefault) {
        e.preventDefault() // Necessary. Allows us to drop.
      }

      if (e.dataTransfer) {
        e.dataTransfer.dropEffect = 'move'
      }

      this.onDragEnter(e)

      return false
    },

    onDrop (e, column, child) {
      if (!column && !child) {
        column = this.getCorrectTarget(e.currentTarget, 'planner-column')
        child = this.getCorrectTarget(e.currentTarget, 'planner-item')
      }

      const targetColumn = this.getColumnFromTarget(column)
      const targetItemId = this.getItemIdFromTarget(child)

      if (this.dragEl === child) {
        // no dropping on self
        return false
      }

      if (this.curChildEl) {
        this.curChildEl.classList.remove('drag-over-item')
      }

      if (this.curColEl) {
        this.curColEl.classList.remove('drag-over')
      }

      if (targetColumn) {
        // get current item column
        const currentColumnEl = this.getCorrectTarget(this.dragEl, 'planner-column')
        if (currentColumnEl) {
          const currentColumn = this.getColumnFromTarget(currentColumnEl)

          // remove dragged item
          this.removeFromColumn(currentColumn, this.currentItem.id)

          // add dragged item to new location
          this.addToColumn(targetColumn, targetItemId, this.currentItem)

          // update selection status
          if (targetColumn === 'overdue') {
            this.overdue.forEach(due => {
              due.selected = this.overdueSelected
            })
          }
          else {
            this.agenda[targetColumn].forEach(ag => {
              ag.selected = this.selected[targetColumn - 1]
            })
          }
        }
      }

      this.cleanup()

      return false
    },

    cleanup () {
      // release the dom nodes
      this.dragEl = null
      this.curColEl = null
      this.curChildEl = null
      this.currentColumn = null
      this.currentItemId = null
      this.currentItem = null
      this.targetColumn = null
      this.targetItemId = null
      this.copyElement = null
      this.pageX = 0
      this.pageY = 0
    },

    moveElement (el, left, top) {
      el.style.left = left + 'px'
      el.style.top = top + 'px'
    },

    getTouchOffsets (el, left, top) {
      const rect = el.getBoundingClientRect()
      return { left: left - rect.width / 2, top: top - rect.height / 2 }
    },

    findTargets () {
      let column, child
      const els = document.elementsFromPoint(this.pageX, this.pageY)

      for (let i = 0; i < els.length; ++i) {
        const el = els[i]
        if (el.classList.contains('planner-item')) {
          child = el
        }
        else if (el.classList.contains('planner-column')) {
          column = el
        }
        if (column && child) break
      }

      return { column, child }
    },

    onTouchMove (e, item) {
      const touchLocation = e.targetTouches[0]

      const touchStart = this.copyElement === null

      // assign box new coordinates based on the touch.
      this.pageX = touchLocation.pageX
      this.pageY = touchLocation.pageY

      const { column, child } = this.findTargets()
      if (column || child) {
        if (touchStart) {
          if (child) {
            this.onDragStart(e, item)
            this.copyElement = child.cloneNode(true)
            this.copyElement.style.position = 'absolute'
            this.copyElement.style.opacity = '0.5'
          }
          else {
            // fail - probably trying to drag a column
            this.cleanup()
            return
          }
        }

        const { left, top } = this.getTouchOffsets(this.copyElement, this.pageX, this.pageY)

        this.moveElement(this.copyElement, left, top)

        // add the copy to the body
        document.body.appendChild(this.copyElement)

        this.onDragEnter(e, column, child)
      }
    },

    onTouchStart (e, item) {
      // we don't do anything here because we want the
      // system to register a move, before we start things
    },

    onTouchEnd (e) {
      if (this.copyElement) {
        // remove the copy to the body
        document.body.removeChild(this.copyElement)

        const { column, child } = this.findTargets()
        if (column || child) {
          this.onDragEnd(e)

          if (this.dragEl === child) {
            // no dropping on self, restore it all
            this.dragEl.style.opacity = '1.0'
            this.cleanup()
          }
          else {
            this.onDrop(e, column, child)
          }
        }
      }
    },

    getCorrectTarget (el, klass) {
      if (!el) {
        return null
      }
      if (el.classList.contains(klass)) {
        return el
      }
      return this.getCorrectTarget(el.parentElement, klass)
    },

    getColumnFromTarget (target) {
      if (target) {
        return target.dataset.column
      }
    },

    getItemIdFromTarget (target) {
      if (target) {
        return target.dataset.id
      }
    },

    removeFromColumn (column, id) {
      let list
      if (column === 'overdue') {
        list = this.overdue
      }
      else {
        list = this.agenda[parseInt(column, 10)]
      }

      id = parseInt(id, 10)

      for (let index = 0; index < list.length; ++index) {
        if (list[index].id === id) {
          list.splice(index, 1)
          return
        }
      }
    },

    addToColumn (column, id, item) {
      let list
      if (column === 'overdue') {
        list = this.overdue
      }
      else {
        list = this.agenda[parseInt(column, 10)]
      }

      // if no id, then add to end of list
      if (!id) {
        list.splice(list.length, 0, item)
        return
      }
      else {
        id = parseInt(id, 10)
      }

      for (let index = 0; index < list.length; ++index) {
        if (list[index].id === id) {
          list.splice(index, 0, item)
          return
        }
      }
    }
  }
}
</script>

<style lang="sass" scoped>
.planner-column
  border: 1px solid transparent
  height: 100%

.planner-column.drag-over
  border: 1px dashed red

.planner-item.drag-over-item
  background: rgba(0,255,0, .1)

.planner-item
  transition: all 0.5s

.planner-item-enter, .planner-item-leave-to
  opacity: 0
  transform: scale(0)

.planner-item-enter-to
  opacity: 1
  transform: scale(1)

.planner-item-move
  transition: transform .5s

</style>
