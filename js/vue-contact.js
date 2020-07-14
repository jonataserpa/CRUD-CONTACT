Vue.use(VueMask.VueMaskPlugin);
Vue.directive('mask', VueMask.VueMaskDirective);

var app = new Vue(
{
  el : "#app",

  data : 
  {
    keywords: "",
    modal : { title: "Add " },
    error : {name : "*", email : "*", address : "*"},
    contact : { id : "", name : "", email : "", address : "", action:"", phones: []},
    contacts: [],
    urlPost : "http://localhost/contact",
    disabledButton : false,
    reverse: false,
    messageResult : "",
    mask: "(##) ####-####",
    phone: "4140028922"
  },

/*   computed: {
		filterContacts : function() {
      return this.contacts.filter((contact) => {
        return contact.name.match(this.search);// || contact.address.match(this.search) || contact.email.match(this.search)
      });
		}
  }, */

  created: function()
  {
    this.allRecords();
  },

  methods : 
  {
    search(event) {
      var params = {
        filterByContact : this.keywords,
        action : 'filterByContact'
      }
      const json = JSON.stringify(params);
      axios.post(this.urlPost, json).then(function (response) 
      {
        console.log(JSON.stringify(response.data));
        app.contacts = JSON.parse(response.data);
      })
      .catch(function (error) 
      {
         console.log(error);
      });
    },

    merge : function()
    {
      if(this.validateForm())
      {
        this.disabledButton = true;
        this.messageResult = "Sending, please wait!";

        app.contact.phones.push(app.listPhones);

        if(app.contact.id == "")
        {
          app.contact.action = "save";
        }else{
          app.contact.action = "update";
        }

        const json = JSON.stringify(app.contact);
        axios.post(this.urlPost, json).then(function(response)
        {
          console.log(response.data);
          var contact = JSON.parse(response.data);
          if(contact.status == "200")
          {
            if(app.contact.action == "save")
            {
              app.resetForm();
              app.resetError();
            }
            app.disabledButton = false;
            app.messageResult  = contact.mensagem;
            app.contact.phones.pop();

            Swal.fire({
              position: 'top-end',
              icon: 'success',
              title: contact.mensagem,
              showConfirmButton: false,
              timer: 2000
            });

          }else{
            app.messageResult  = contact.mensagem;
            
            Swal.fire({
              icon: 'error',
              title: 'Oops... please try again later',
              text: contact.mensagem,
              footer: '<a href>Contact Administrador!</a>'
            })
          }
          app.allRecords();
        })
        .catch(function (error) 
        {
           console.log(error);
        });
      }
    },

    editContact: function (contact) 
    {

      this.modal.title = 'Edit';
      app.contact.id = contact.c_id;
      app.contact.name = contact.c_name;
      app.contact.email = contact.c_email;
      app.contact.address = contact.c_address;
      app.messageResult = "";

      this.contact.action = "findById";
      const json = JSON.stringify(this.contact);
      axios.post(this.urlPost, json).then(function (response) 
      {
        console.log(JSON.parse(response.data));
        app.contact.phones = JSON.parse(response.data);

        $("#modalForm").modal(
        {
          show: true
        });

      })
      .catch(function (error) 
      {
         console.log(error);
      });

    },

    allRecords: function()
    {
      axios.get(this.urlPost).then(function (response) 
      {
        console.log(JSON.stringify(response.data));
        app.contacts = JSON.parse(response.data);
      })
      .catch(function (error) 
      {
         console.log(error);
      });
    },

    validateForm : function()
    {
      var error = 0;
      this.resetError();
      if(this.contact.name.length < 4)
      {
        this.error.name = "Please, insert a valid name (4 characters)";
        error++;
      }

      if(this.contact.email.indexOf("@") < 0)
      {
        this.error.email = "Invalid email";
        error++;
      }

      if(this.contact.address.length < 4)
      {
        this.error.address = "Invalid message (10 characters)";
        error++;
      }
      return (error === 0);
    },
    resetForm : function()
    {
      this.contact.name = "";
      this.contact.email = "";
      this.contact.address = "";
      this.$refs.name.focus();
    },
    resetError : function()
    {
      this.error.name = "*";
      this.error.email = "*";
      this.error.address = "*";
    },
    
    addPhone : function()
    {

      if (document.getElementById("tipo").value == "Open this select menu" || document.getElementById("phone").value == "") 
      {
          
          var msg="Obrigatório";
          if(document.getElementById("tipo").value == "Open this select menu")
          {
              document.getElementById("tipo").focus();
              msg="Field Tipo Invalid !";
          }else if(document.getElementById("phone").value == ""){
              document.getElementById("phone").focus();
              msg="Field Phone Invalid !";
          }

          Swal.fire({
              type: 'error',
              title: msg,
              showConfirmButton: false,
              timer: 2000
          })
          return false;
      }
      
        var params = {
          p_tipo : document.getElementById("tipo").value,
          p_numero : document.getElementById("phone").value
        }

        app.contact.phones.push(params);
        $('#phone').val(""); 
        $('#tipo').focus(); 

    },

    removeContact : function(contact) 
    {
      var msg= contact.c_name + " will be deleted in the database!";
      
      Swal.fire({
        title: " Are you sure? ",
        text: msg,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: "Yes, delete contact!",
      }).then((result) => {
        if (result.value) 
        {
          app.contact.id = contact.c_id;
          app.contact.action = "delete";
          const json = JSON.stringify(app.contact);
          axios.post(this.urlPost, json).then(function (response) 
          {
            app.allRecords();

            Swal.fire(
              'Deleted!',
              'Your contact has been deleted.',
              'success'
            )
          })
          .catch(function (error) 
          {
             console.log(error);
          });
        }
      })
      
    },
    
    removePhone : function(index) 
    {
      app.contact.phones.splice(index, 1);
    },
    
    
    validaEmail : function(email){
      app.contact.email = email;
      app.contact.action = "validaEmail";
      const json = JSON.stringify(app.contact);
      axios.post(this.urlPost, json).then(function (response) 
      {
        console.log(response.data.status);
        if(response.data.status == "500"){
          app.contact.email = "";
          app.messageResult = response.data.mensagem;
          
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: app.messageResult,
            footer: 'Favor insert new email!'
          });
        }else{
          app.messageResult = "";
        }

        $('#email').focus(); 
        
      })
      .catch(function (error) 
      {
        console.log(error);
      });
    },

    openForm : function(show)
    {
      if(show)
      {
        $("#modalForm").show("slow");
        this.resetForm();
        this.resetError();
      }
      else{
        $("#modalForm").hide("slow");
      }
    }
  }
});
