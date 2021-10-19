import Vue from 'vue'
import Card from './Card'
import Child from './Child'
import Button from './Button'
import Checkbox from './Checkbox'
import SideMenuItem from './SideMenuItem'
import CollectionItem from './CollectionItem'
import DateRangePicker from './DateRangePicker'
import Chart from './Chart'
import { HasError, AlertError, AlertSuccess } from 'vform'

// Components that are registered globaly.
[
  Card,
  Child,
  Button,
  Checkbox,
  SideMenuItem,
  CollectionItem,
  DateRangePicker,
  Chart,
  HasError,
  AlertError,
  AlertSuccess
].forEach(Component => {
  Vue.component(Component.name, Component)
})
