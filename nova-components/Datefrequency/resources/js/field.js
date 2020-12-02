Nova.booting((Vue, router, store) => {
  Vue.component('index-datefrequency', require('./components/IndexField'))
  Vue.component('detail-datefrequency', require('./components/DetailField'))
  Vue.component('form-datefrequency', require('./components/FormField'))
})
