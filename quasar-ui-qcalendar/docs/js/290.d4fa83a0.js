(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([[290],{ba57:function(e,n,a){"use strict";a.r(n),n["default"]="<template>\n  <div style=\"max-width: 800px; width: 100%;\">\n    <q-calendar\n      v-model=\"selectedDate\"\n      view=\"day-resource\"\n      :resources=\"resources\"\n      :resource-height=\"50\"\n      interval-minutes=\"30\"\n      bordered\n      sticky\n      locale=\"en-us\"\n      style=\"height: 200px; max-width: 800px; width: 100%;\"\n    />\n  </div>\n</template>\n\n<script>\nexport default {\n  data () {\n    return {\n      selectedDate: '2019-04-01',\n      resources: [\n        { label: 'John' },\n        { label: 'Mary' },\n        { label: 'Susan' },\n        { label: 'Olivia' },\n        { label: 'Board Room' },\n        { label: 'Room-1' },\n        { label: 'Room-2' }\n      ]\n    }\n  }\n}\n<\/script>\n"}}]);