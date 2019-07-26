var express = require('express')
var Router = express.Router()
var mongoose = require('mongoose')
var User = require('../models.js')
var Events = require('../modelsEvent.js')
const session = require('express-session');

//var where = require("lodash.where");
//var Storage = require('../Storage')
mongoose.connect('mongodb://localhost/dbagenda')

var sess;

Router.post('/login', async function (req, res) {
  const result = await User.find({ user: req.body.user, pass:  req.body.user });
  if (result.length == 1) {
    //sess=req.session;
    //sess.id=result[0].id;
    //localStorage.setItem('user_id', result[0].id)
    
    return res.json({ msg:"Validado", id:result[0].id });
  } else {
    return res.json({  msg: "Rechazado" });
  }
  })

  Router.post('/events/all', async function (req, res) {
    const result = await Events.find({ user_id: req.body.user_id});
    if (result.length > 0) {
      return res.json(result);
    } 
    })
  
    Router.post('/events/new', async function (req, res) {

      const result = await Events.find();
      let corr = result.length + 1
    let evento = new Events({ 
                          id : corr,
                          user_id: req.body.user_id, 
                          title:req.body.title,
                          start:req.body.start,
                          end:req.body.end,
                          allDay:req.body.allDay })

          evento.save((err) => {
            if (err) {
              console.log(err) 
              res.send("Invalido")
            }
            res.send("Valido")  
        });
      })
  
      Router.post('/events/delete/:id', async function (req, res) {
        const result = await Events.remove({ id: req.params.id}, 
          (error) => {
            if (error){
              res.send("Invalido")
            }
            res.send("Valido")
          });
        })

        Router.post('/events/update/:id', async function (req, res) {
          const result = await Events.update({ id: req.params.id}, {
          start: req.body.start_date,
          end: req.body.end_date 
        }, 
            (error) => {
              if (error){
                console.log(error) 
                res.send("Invalido")
              }
              console.log(req.params.id) 
              res.send("Valido")
            });
          })

      


/* Prueba 6 otra vez con variable 

Router.post('/login', function (req, res) {

  const result = User.find({ user: req.body.user, pass: req.body.pass });
  console.log(result);
  if (result) {
  res.send("Validado")
  } else {
  res.send("Rechazado")
  }
  })



/* Prueba 5 asincrono 

Router.post('/login', async function (req, res) {

  await User.find({ user: req.body.user, pass: req.body.pass }, (err) => {
    console.log(err);
  if (err) {
  res.send("Rechazado")
  } else {
  res.send("Validado")
  }
  
  });
  })


/* Prueba 4 con send 

Router.post('/login', function (req, res) {

  User.find({ user: req.body.user, pass: req.body.pass }, (err) => {
  console.log(err);
  if (err) {
  res.send("Rechazado")
  } else {
  res.send("Validado")
  }
  
  });
  })



/* Prueba 3 asignando variable

Router.post('/login', function(req, res) {

  var result = User.find({ user : req.body.user, pass : req.body.pass  }, (err) => {
  /*if (err) {
  return res.json({  data: "InValido"  });
  }
  /*console.log(result);
  if(result == null) {
    return res.json({  data: "InValido"  });
  } else {
    return res.json({  data: "Validado"  });
  }


  });

  })
  
Prueba 2 VAlidando solo con usuario

Router.post('/login', function(req, res) {

  User.find({ user : req.body.user  }, (err) => {
  if (err) {
  return res.json({  data: "InValido"  });
  }

  return res.json({  data: "Validado"  });

  });
  })
  



/* prueba 1 con json
Router.post('/login', function(req, res) {
  Storage.getData()
    .then((data) => {

      if(data.filter(data => (data.Usuario == req.body.user) && (data.Pass == req.body.pass )).length == 1) 
      {
        res.json({
          "datos":"Validado"
        });
      }
    })
    .catch((err) => {
      res.json({
        "datos": err
      });
    });

})
*/

module.exports = Router
