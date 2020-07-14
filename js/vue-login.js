var app = new Vue(
{
  el : "#app",

  data : 
  {
    error : {email : "", password: ""},
    contact : { email : "", password : ""},
    urlPost : "http://localhost/login",
    disabledButton : false,
  },

  methods : 
  {
    
    send : function()
    {
      if(this.validateForm())
      {
        this.disabledButton = true;
        let timerInterval

        Swal.fire({
        title: 'Wait login in process!',
        html: 'I will close in <b></b> milliseconds.',
        timer: 1000,
        timerProgressBar: true,
            onBeforeOpen: () => {
                Swal.showLoading()
                timerInterval = setInterval(() => {
                    const content = Swal.getContent()
                    if (content) {
                        const b = content.querySelector('b')
                        if (b) {
                            b.textContent = Swal.getTimerLeft()
                        }
                    }
                }, 100)
            },
            onClose: () => {
                clearInterval(timerInterval)
            }
        }).then((result) => {
            if (result.dismiss === Swal.DismissReason.timer) {
                console.log('I was closed by the timer')
            }
        })

        /* var md5 = $.md5(app.contact.password);
        app.contact.password = md5; */
        const json = JSON.stringify(app.contact);
        axios.post(this.urlPost, json).then(function(response)
        {
          app.contacts = JSON.parse(response.data);
          if(app.contacts.codigo == "1")
          {
            location.href = "/home";

          }else if(app.contacts.codigo == "0"){
            
            Swal.fire({
              icon: 'error',
              title: 'Oops... Login Invalid!',
              text: app.contacts.mensagem,
              footer: '<a href>Contact Administrador!</a>'
            })
          }
        })
        .catch(function (error) 
        {
           console.log(error);
        });
      }
    },

    validateForm : function()
    {
      var error = 0;
      this.resetError();
      if(this.contact.email.indexOf("@") < 0)
      {
        this.error.email = "Invalid email";
        error++;
      }

      if(this.contact.password.length < 4)
      {
        this.error.password = "Please, insert password (4 characters)";
        error++;
      }

      return (error === 0);
    },

    resetError : function()
    {
        this.error.email = "*";
        this.error.password = "*";
    },
  }
});
