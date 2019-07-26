$(function(){
  var l = new Login();
})


class Login {
  constructor() {
    this.submitEvent()
  }

  submitEvent(){
    $('form').submit((event)=>{
      event.preventDefault()
      this.sendForm()
    })
  }

  sendForm(){
    let form_data = new FormData();
    form_data.append('username', $('#user').val())
    form_data.append('password', $('#password').val())
    $.ajax({
      url: '../server/check_login.php',
      dataType: "json",
      cache: false,
      processData: false,
      contentType: false,
      data: form_data,
      type: 'POST',
      success: function(php_response){
        console.log(php_response);
        if (php_response.conexion == "OK") {
          if(php_response.msg == 'OK'){   
            window.location.href = 'main.html';
          }
          else
          { 
            alert("Usuario incorrecto");
          }
        }else {
          alert(php_response.conexion);
        }
      },
      error: function(err){
        console.log(err);
        alert("error en la comunicación con el servidor");
      }
    })
  }
}
