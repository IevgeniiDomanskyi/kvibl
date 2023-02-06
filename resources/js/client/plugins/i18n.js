import Vue from 'vue'
import VueI18n from 'vue-i18n'

Vue.use(VueI18n)

class i18nFormatter {
  constructor(options) {
    //
  }

  interpolate(message, values) {
    for (const k in values) {
      const search = new RegExp(':' + k, 'gi')
      message = message.replace(search, values[k])
    }

    return [message]
  }
}

export const i18n = new VueI18n({
  locale: 'en',
  fallbackLocale: 'en',
  formatter: new i18nFormatter(),
})

export const setLocale = (locale) => {
  i18n.locale = locale
  document.querySelector('html').setAttribute('lang', locale)
}

export const setTexts = (locale, messages) => {
  i18n.setLocaleMessage(locale, messages)
}