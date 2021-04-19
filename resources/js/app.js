/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('menu-component', require('./components/MenuComponent.vue').default);
Vue.component('create-attribute-component', require('./components/CreateAttributeComponent.vue').default);
Vue.component('create-value-attribute-component', require('./components/CreateValueAttributeComponent.vue').default);
Vue.component('edit-value-attribute-component', require('./components/EditValueAttributeComponent.vue').default);
Vue.component('input-edit-value-attribute-component', require('./components/InputEditValueAttributeComponent.vue').default);
Vue.component('input-edit-attribute-component', require('./components/InputEditAttributeComponent.vue').default);
Vue.component('img-modal-component', require('./components/ImgModalComponent.vue').default);
Vue.component('edit-element-component', require('./components/EditElementComponent.vue').default);
Vue.component('create-note-component', require('./components/CreateNoteComponent.vue').default);
Vue.component('create-section-component', require('./components/CreateSectionComponent.vue').default);
Vue.component('functions-component', require('./components/FunctionsComponent.vue').default);




/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

/*const app = new Vue({
    el: '#app',
    data: {
      message: 'message'
    }
});*/

var elements = ['#create-attribute', '#create-value-attribute', '#edit-value-attribute','#input-edit-value-attribute','#input-edit-attribute','#img-modal','#edit-element','#create-note','#create-section', '#functions', '#chart'];

for(i = 0; i <= elements.length; i++){
    
    if ($(elements[i]).length){
        const app = new Vue({
            el: elements[i], 
        });
    }
}

$('#search-element').keyup(function(){
  var value = $('#search-element').val();
  $.ajax({
    url: "admin/search_element",
    type: 'GET',
    data: {
      value_text: value,
    },
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    success: (data) => {
      if(data.length != null){
        for(let i = 0; i < data.length; i++){
          $('.result-search').empty();
          let sp = "'";
          $('.result-search').append('<li><i class="fa fa-hand-o-right hand-right" aria-hidden="true"></i><a onclick="showResultSearch(event, ' + sp + data[i].complex_id + sp + ')">' + data[i].element_name + '</a></li>');
        }
      }
    }
  })
});



