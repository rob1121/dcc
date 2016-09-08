require("./bootstrap");
import Vuetable from 'vuetable/src/components/Vuetable.vue';
import VuetablePagination from 'vuetable/src/components/VuetablePagination.vue';
import VuetablePaginationDropdown  from 'vuetable/src/components/VuetablePaginationDropdown.vue';

Vue.component('vuetable', Vuetable);
Vue.component('vuetable-pagination', VuetablePagination);
Vue.component('vuetable-pagination-dropdown', VuetablePaginationDropdown);
var E_SERVER_ERROR = 'Error communicating with the server'

  // fields definition
  var tableColumns = [
      {
          name: 'id',
          title: '',
          dataClass: 'text-center',
          callback: 'showDetailRow'
      },
      {
          name: 'name',
          sortField: 'name',
      },
      {
          name: 'email',
          sortField: 'email',
      },
      {
          name: 'nickname',
          sortField: 'nickname',
          callback: 'allCap'
      },
      {
          name: 'birthdate',
          sortField: 'birthdate',
          callback: 'formatDate|D/MM/Y'
      },
      {
          name: 'gender',
          sortField: 'gender',
          titleClass: 'text-center',
          dataClass: 'text-center',
          callback: 'gender'
      },
      {
          name: '__actions',
          dataClass: 'text-center',
      }
  ]

  Vue.config.debug = true

  new Vue({
      el: '#app',
      data: {
          searchFor: '',
          fields: tableColumns,
          sortOrder: [{
              field: 'name',
              direction: 'asc'
          }],
          multiSort: true,
          perPage: 10,
          paginationComponent: 'vuetable-pagination',
          paginationInfoTemplate: 'แสดง {from} ถึง {to} จากทั้งหมด {total} รายการ',
          itemActions: [
              { name: 'view-item', label: '', icon: 'fa fa-file-pdf-o', class: 'btn btn-info', extra: {'title': 'View', 'data-toggle':"tooltip", 'data-placement': "left"} },
              { name: 'edit-item', label: '', icon: 'fa fa-pencil', class: 'btn btn-warning', extra: {title: 'Edit', 'data-toggle':"tooltip", 'data-placement': "top"} },
              { name: 'delete-item', label: '', icon: 'fa fa-remove', class: 'btn btn-danger', extra: {title: 'Delete', 'data-toggle':"tooltip", 'data-placement': "right" } }
          ],
          moreParams: [],
      },
      watch: {
          'perPage': (val, oldVal) => {
              this.$broadcast('vuetable:refresh')
          },
          'paginationComponent': (val, oldVal) => {
              this.$broadcast('vuetable:load-success', this.$refs.vuetable.tablePagination)
              this.paginationConfig(this.paginationComponent)
          }
      },
      methods: {
          /**
           * Callback functions
           */
          allCap(value) {
              return value.toUpperCase()
          },
          gender(value) {
            return value == 'M'
              ? '<span class="label label-info"><i class="fa fa-star"></i> Male</span>'
              : '<span class="label label-success"><i class="fa fa-heart"></i> Female</span>'
          },
          formatDate(value, fmt) {
              if (value == null) return ''
              fmt = (typeof fmt == 'undefined') ? 'D MMM YYYY' : fmt
              return moment(value, 'YYYY-MM-DD').format(fmt)
          },
          showDetailRow(value) {
              var icon = this.$refs.vuetable.isVisibleDetailRow(value) ? 'fa fa-minus-sign' : 'fa fa-plus-sign'
              return [
                  '<a class="show-detail-row">',
                      '<i class="' + icon + '"></i>',
                  '</a>'
              ].join('')
          },
          /**
           * Other functions
           */
          setFilter() {
              this.moreParams = [
                  'filter=' + this.searchFor
              ]
              this.$nextTick(() => this.$broadcast('vuetable:refresh'))
          },
          resetFilter() {
              this.searchFor = ''
              this.setFilter()
          },

          preg_quote( str ) {
              return (str+'').replace(/([\\\.\+\*\?\[\^\]\$\(\)\{\}\=\!\<\>\|\:])/g, "\\$1");
          },
          highlight(needle, haystack) => {
              return haystack.replace(
                  new RegExp('(' + this.preg_quote(needle) + ')', 'ig'),
                  '<span class="highlight">$1</span>'
              )
          },
          makeDetailRow(data) => {
              return [
                  '<td colspan="7">',
                      '<div class="detail-row">',
                          '<div class="form-group">',
                              '<label>Name: </label>',
                              '<span>' + data.name + '</span>',
                          '</div>',
                          '<div class="form-group">',
                              '<label>Email: </label>',
                              '<span>' + data.email + '</span>',
                          '</div>',
                          '<div class="form-group">',
                              '<label>Nickname: </label>',
                              '<span>' + data.nickname + '</span>',
                          '</div>',
                          '<div class="form-group">',
                              '<label>Birthdate: </label>',
                              '<span>' + data.birthdate + '</span>',
                          '</div>',
                          '<div class="form-group">',
                              '<label>Gender: </label>',
                              '<span>' + data.gender + '</span>',
                          '</div>',
                      '</div>',
                  '</td>'
              ].join('')
          },
          rowClassCB(data, index) {
              return (index % 2) === 0 ? 'positive' : ''
          },
          paginationConfig(componentName) {
              console.log('paginationConfig: ', componentName)
              if (componentName == 'vuetable-pagination') {
                  this.$broadcast('vuetable-pagination:set-options', {
                      wrapperClass: 'pagination',
                      icons: { first: '', prev: '', next: '', last: ''},
                      activeClass: 'active',
                      linkClass: 'btn btn-default',
                      pageClass: 'btn btn-default'
                  })
              }
              if (componentName == 'vuetable-pagination-dropdown') {
                  this.$broadcast('vuetable-pagination:set-options', {
                      wrapperClass: 'form-inline',
                      icons: { prev: 'fa fa-chevron-left', next: 'fa fa-chevron-right' },
                      dropdownClass: 'form-control'
                  })
              }
          },
      },
      events: {
          'vuetable:row-changed': data => {
              console.log('row-changed:', data.name)
          },
          'vuetable:row-clicked': (data, event) => {
              console.log('row-clicked:', data.name)
          },
          'vuetable:cell-clicked': (data, field, event) => {
              console.log('cell-clicked:', field.name)
              if (field.name !== '__actions') {
                  this.$broadcast('vuetable:toggle-detail', data.id)
              }
          },
          'vuetable:action': (action, data) => {
              console.log('vuetable:action', action, data)
              if (action == 'view-item') {
                  alert(action+" "+ data.name)
              } else if (action == 'edit-item') {
                  alert(action+" "+ data.name)
              } else if (action == 'delete-item') {
                  alert(action+" "+ data.name)
              }
          },
          'vuetable:load-success': response => {
              var data = response.data.data
              console.log(data)
              if (this.searchFor !== '') {
                  for (n in data) {
                      data[n].name = this.highlight(this.searchFor, data[n].name)
                      data[n].email = this.highlight(this.searchFor, data[n].email)
                  }
              }
          },
          'vuetable:load-error': response => {
              if (response.status == 400) {
                  alert('Something\'s Wrong!'+" "+ response.data.message+" "+ 'error')
              } else {
                  alert('Oops'+" "+ E_SERVER_ERROR+" "+ 'error')
              }
          }
      }
  })