window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';


// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });

    
    function getAttributesForChart(type){
      let route = "admin/search_attributes_" + type;
      $.ajax({
        url: route,
        type: 'GET',
        data: {},
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success: (data) => {
          let arr = new Array();
            if(data.length != null){
              let count = 0;
              for(let i = 0; i < data.length; i++){
                for(let j = 0; j < data[i].length; j++){
                  arr[count] = data[i][j].attribute_double;
                  count++;
                }
              }
              //console.log(arr);
              showChart(arr);
            }
        }
      })
    }

    
    //getAttributesForChart('double');

  

  import Chart from 'chart.js/auto';

    function showChart(attrDouble){
      var ctx = document.getElementById('myChart');
      var myChart = new Chart(ctx, {
          type: 'line',
          data: {
              labels: attrDouble,
            datasets: [
              {
                label: 'Double',
                data: attrDouble,
                borderColor: 'rgba(210, 85, 66, 1)',
                backgroundColor: 'rgba(66, 162, 235, 0.2)',
              }
            ]
  
          },
          options: {}
      });
    }


