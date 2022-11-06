import { createApp } from 'vue'
import { App as appCapacitor } from '@capacitor/app'

import App from './components/App.vue'

import store from './store'
import route from './routes'

import '~/service/axios'
import pusher from '~/service/pusher'

import 'dayjs/locale/id'

import day from 'dayjs'
import isBetween from 'dayjs/plugin/isBetween'
import relativeTime from 'dayjs/plugin/relativeTime'
import localizedFormat from 'dayjs/plugin/localizedFormat'

// import 'intro.js/introjs.css'
import { VueReCaptcha } from 'vue-recaptcha-v3'
import { Form, Field, ErrorMessage } from 'vee-validate'

import '~/service/yup'

const app = createApp(App)

app.component('Form', Form)
app.component('Field', Field)
app.component('ErrorMessage', ErrorMessage)

day.locale('id')
day.extend(isBetween)
day.extend(relativeTime)
day.extend(localizedFormat)

const mobile = /iphone|ipad|tablet|(windows(?!.*phone)(.*touch))|kindle|playbook|silk|ipod|android/i.test(navigator.userAgent.toLowerCase())

const rupiah = v => v.toString().replace(/(\d)(?=(\d{3})+(?:\.\d+)?$)/g, "$1\.")

app.provide('day', day)
app.provide('mobile', mobile)
app.provide('pusher', pusher)
app.provide('rupiah', rupiah)

app.provide('baseurl', 'https://skripsi.project-001.anoonion.xyz/')

app.use(VueReCaptcha, {
    siteKey: '6LeEEBceAAAAAIwtJLaUvGJq-OJRoLMxOlc7QOaQ',
    loaderOptions: {
        autoHideBadge: true,
        useRecaptchaNet: true
    }
})

app.use(store)
app.use(route)

appCapacitor.addListener('appUrlOpen', function (event) {
    const url = new URL(event.url)

    if (url) {
        route.push({
            path: url.pathname,
            query: Object.fromEntries(new URLSearchParams(url.search))
        })
    }
})

app.mount('#app')
