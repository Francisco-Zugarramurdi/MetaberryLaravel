const form = document.getElementById("creationForm")
const name = document.getElementById('name')
const photo = document.getElementById('photo')
const email = document.getElementById('email')
const points = document.getElementById('points')
const totalPoints = document.getElementById('totalPoints')
const card = document.getElementById('card')
const password = document.getElementById('password')
const error = document.getElementById('error')


form.addEventListener("submit", (e) => {
  
  error.innerHTML = ""

  let validated = validate()

  if(validated.length > 0){
    e.preventDefault();
    for(i=0; i<validated.length; i++){
      console.log(validated[i])
      error.innerHTML += `<p>${validated[i]}</p>` 
  }
  }
});

const validate = () =>{
    const cardRegex =/^4[0-9]{12}(?:[0-9]{3})?$/
    const passwordRegex =/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/
    const emailRegex=/(?i)^([a-z0-9+-]+)(.[a-z0-9+-]+)*@([a-z0-9-]+.)+[a-z]{2,6}$/
    const photoRegex=/(?i)[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()@:%_\+.~#?&//=]*)/

    let error = []
    
    if(!cardRegex.test(card.value)){
        error.push("Incorrect credit card format")
    }

    if(!emailRegex.test(email.value)){
        error.push("Incorrect email format")
    }
    
    if(!photoRegex.test(photo.value)){
        error.push("Incorrect image url format")
    }
    
    if(!passwordRegex.test(password.value)){
      error.push("Incorrect password, the password should have a capital letter a number and must be at least 8 characters long")
    }

    if(totalPoints<points){
        error.push("The total points cann't be higher than the current ones")
    }

    return error
}