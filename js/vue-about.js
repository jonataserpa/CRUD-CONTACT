new Vue({
    el: "#app",
    data: {
      keywords: ''
    },
    methods: {
       queryForKeywords(event) {
         console.log("keywords value: " + this.keywords);
         console.log("event value: " + event.target.value);
      }
    }
  })